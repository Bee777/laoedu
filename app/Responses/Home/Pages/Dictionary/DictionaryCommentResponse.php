<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 3/29/2019
 * Time: 10:28 PM
 */

namespace App\Responses\Home\Pages\Dictionary;


use App\Dictionary;
use App\DictionaryComment;
use App\Http\Controllers\Helpers\Helpers;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DictionaryCommentResponse implements Responsable
{

    protected $type;

    /**
     * DictionaryCommentResponse constructor.
     * @param $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response | DictionaryReplyCommentResponse
     */
    public function toResponse($request)
    {
        if (Helpers::isAjax($request)) {
            $user = $request->user('api');
            //@check dictionary
            $dictionary_id = $this->getDictionaryId($request->get('dictionary_id'));
            if (!isset($dictionary_id)) {
                return response()->json(['success' => false, 'msg' => 'The dictionary does not exits!']);
            }
            //@check dictionary
            if ($this->type === 'get') {
                $paginateLimit = ($request->exists('limit') && !empty($request->get('limit'))) ? $request->get('limit') : 12;
                $paginateLimit = Helpers::isNumber($paginateLimit) ? $paginateLimit : 12;
                $comments = DictionaryComment::where('dictionary_id', $dictionary_id)->orderBy('id', 'desc')->paginate($paginateLimit);
                $comments->appends(['limit' => $paginateLimit]);
                $comments->map(function ($comment) use ($user) {
                    $this->mapComment($comment, $user);
                    return $comment;
                });
                return response()->json(['success' => true, 'data' => $comments]);
            }

            if ($this->type === 'manage') {//create and update
                /**
                 * @ForReplyComment
                 */
                $replyActions = ['reply', 'edit-reply'];
                if (in_array($request->get('comment')['action'], $replyActions, true)) {//for reply actions
                    return (new DictionaryReplyCommentResponse('manage'))->toResponse($request);
                }
                /**
                 * @EndForReplyComment
                 */

                /**
                 * @ForComment
                 */
                $comment = null;
                $hash_id = null;
                $exist_comment = $this->getDictionaryComment($request->get('id'), $user);

                if (!isset($exist_comment) && isset($request->get('comment')['action']) && $request->get('comment')['action'] === 'edit') {
                    return response()->json(['success' => false, 'msg' => 'The dictionary comment does not exits!']);
                }

                if (isset($exist_comment)) {
                    $exist_comment->text = $request->get('text');
                    $exist_comment->save();
                    $comment = $exist_comment;
                } else {
                    $comment = new DictionaryComment();
                    if (isset($user)) {
                        $comment->type = 'user';
                        $comment->user_id = $user->id;
                    } else {
                        $comment->type = 'guest';
                        $comment->name = $request->get('name');
                        $comment->surname = $request->get('surname');
                    }
                    $comment->dictionary_id = $dictionary_id;
                    $comment->text = $request->get('text');
                    $comment->save();
                    $hash_id = $this->getHashCommentId($comment->id);
                    $comment->hash_id = $hash_id;
                    $comment->save();
                }
                $this->mapComment($comment, $user);
                if (isset($hash_id)) {
                    $comment->hash_id = $hash_id;
                }
                return response()->json(['success' => true, 'msg' => 'The comment was successfully saved', 'comment' => $comment]);
                /**
                 * @EndForComment
                 */
            }

            if ($this->type === 'delete') {
                /**
                 * @ForReplyComment
                 */
                if ((bool)$request->get('isReplyComment') === true && $request->get('isReplyComment') !== 'undefined') {//for reply actions
                    return (new DictionaryReplyCommentResponse('delete'))->toResponse($request);
                }
                /**
                 * @EndForReplyComment
                 */

                $exist_comment = $this->getDictionaryComment($request->get('id'), $user);
                if (isset($exist_comment)) {
                    DictionaryComment::find($exist_comment->id)->delete();
                    return response()->json(['success' => true, 'msg' => 'The comment was successfully deleted.']);
                }
                return response()->json(['success' => false, 'msg' => 'Failed to delete the comment.']);
            }
        }
    }

    public function getDictionaryId($id)
    {
        $data = Dictionary::find($id);
        if (isset($data)) {
            return $data->id;
        }
        return null;
    }

    public function getDictionaryComment($id, $user)
    {
        if (isset($user)) {
            return DictionaryComment::find($id);
        }
        return DictionaryComment::where('hash_id', $id)->first();
    }

    public function mapComment($comment, $current_user, $isReplyComment = false): void
    {
        $result_comment = new \StdClass();
        $user = $comment->user;
        $comment->hash_id = substr($comment->hash_id, 96, -1);
        if (isset($user)) {
            $comment->name = $user->name . ' ' . $user->last_name;
            $comment->image = url('/') . $user->userInfo['imagePath'] . $user->userInfo['preThumb'] . $user->image;
        } else {
            $comment->name = $comment->name . ' ' . $comment->surname;
            $comment->image = url('/') . '/assets/images/user_profiles/gender-neutral-user-v1.png';
        }
        $comment->comment_actions = ['reply' => true, 'edit' => false, 'delete' => false];
        if ($comment->type === 'guest') {
            $comment->comment_actions = ['reply' => true, 'edit' => false, 'delete' => isset($current_user)];
        } else if (isset($current_user)) {
            $same_user = $current_user->id === $comment->user_id;
            $comment->comment_actions = ['reply' => true, 'edit' => $same_user, 'delete' => $same_user];
        }
        //comment
        $result_comment->text = $comment->text;
        $result_comment->type = $comment->type;
        $result_comment->created_ago = $comment->updated_at->diffForHumans();
        $result_comment->showReply = false;
        $result_comment->action = '';
        $result_comment->poster = [
            'text' => '',
            'active' => false,
            'placeholder' => 'Write a comment...',
            'buttonText' => 'Post',
            'hideButton' => false
        ];
        $comment->comment = $result_comment;
        //comment
        //validator
        $comment->validated = json_decode(json_encode([], JSON_FORCE_OBJECT));
        if (!$isReplyComment) {//@for only comment
            $comment->replies;
            $comment->replies->map(function ($reply_comment) use ($current_user) {
                $reply_comment->isReplyComment = true;
                $this->mapComment($reply_comment, $current_user, true);
                return $reply_comment;
            });
        } else {//@for reply comment
            $comment->replies = [];
        }
        unset($comment->user);
    }

    public function getHashCommentId($id)
    {
        return encrypt(Str::random() . $id);
    }
}
