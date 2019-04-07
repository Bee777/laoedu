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
use App\DictionaryCommentReply;
use App\Http\Controllers\Helpers\Helpers;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DictionaryReplyCommentResponse implements Responsable
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
     * @return \Illuminate\Http\Response
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

            if ($this->type === 'manage') {//create and update
                $reply_comment = null;
                $hash_id = null;
                $action = $request->get('comment')['action'] ?? '';
                $exist_comment = $this->getDictionaryComment($request->get('id'), $action, $user);
                $exist_reply_comment = $this->getDictionaryReplyComment($request->get('id'), $user);
                if (!isset($exist_comment) && $action === 'reply') {
                    return response()->json(['success' => false, 'msg' => 'The dictionary comment does not exits!']);
                }
                if (!isset($exist_reply_comment) && $action === 'edit-reply') {
                    return response()->json(['success' => false, 'msg' => 'The dictionary reply comment does not exits!']);
                }
                if (isset($exist_reply_comment) && $action === 'edit-reply') {//for update reply comment
                    $exist_reply_comment->text = $request->get('text');
                    $exist_reply_comment->save();
                    $reply_comment = $exist_reply_comment;
                }

                if (isset($exist_comment) && $action === 'reply') {//for post reply comment
                    $reply_comment = new DictionaryCommentReply();
                    if (isset($user)) {
                        $reply_comment->type = 'user';
                        $reply_comment->user_id = $user->id;
                    } else {
                        $reply_comment->type = 'guest';
                        $reply_comment->name = $request->get('name');
                        $reply_comment->surname = $request->get('surname');
                    }
                    $reply_comment->dictionary_comment_id = $exist_comment->id;
                    $reply_comment->text = $request->get('text');
                    $reply_comment->save();
                    $hash_id = $this->getHashCommentId($reply_comment->id);
                    $reply_comment->hash_id = $hash_id;
                    $reply_comment->save();
                }
                $this->mapComment($reply_comment, $user);
                if (isset($hash_id)) {
                    $reply_comment->hash_id = $hash_id;
                }
                return response()->json(['success' => true, 'msg' => 'The reply comment was successfully saved', 'comment' => $reply_comment]);
            }

            if ($this->type === 'delete') {
                $exist_reply_comment = $this->getDictionaryReplyComment($request->get('id'), $user);
                if (isset($exist_reply_comment)) {
                    DictionaryCommentReply::find($exist_reply_comment->id)->delete();
                    return response()->json(['success' => true, 'msg' => 'The reply comment was successfully deleted.']);
                }
                return response()->json(['success' => false, 'msg' => 'Failed to delete the reply comment.']);
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

    public function getDictionaryReplyComment($id, $user)
    {
        if (isset($user)) {
            return DictionaryCommentReply::find($id);
        }
        return DictionaryCommentReply::where('hash_id', $id)->first();
    }

    public function getDictionaryComment($id, $type, $user)
    {
        if (isset($user) || $type === 'reply') {
            return DictionaryComment::where('id', $id)->orWhere('hash_id', $id)->first();
        }
        return DictionaryComment::where('hash_id', $id)->first();
    }

    public function mapComment($comment, $current_user): void
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
        $comment->isReplyComment = true;
        $comment->comment = $result_comment;
        //comment
        //validator
        $comment->validated = json_decode(json_encode([], JSON_FORCE_OBJECT));
        $comment->replies = [];
        unset($comment->user);
    }

    public function getHashCommentId($id)
    {
        return encrypt(Str::random() . $id);
    }
}
