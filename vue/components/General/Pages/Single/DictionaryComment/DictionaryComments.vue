<template>
    <div class="single-dictionary-comments-container">
        <div class="fire-spinner" v-if="isLoading"></div>
        <div class="user-comment-poster">
            <Poster ref="main-poster" :isHideUserImage="!LoggedIn()" placeholder="Write a comment..." buttonText="Post"
                    :ImageUrl="`${baseUrl}${authUserInfo.thumb_image}`"
                    v-model="user.text"
                    @onPosterButtonClick="postComment(user)">
                <template slot="poster-top" v-if="!LoggedIn()">
                    <div class="user-commenter-container flex guest-user">
                        <div class="flex flex-scale-auto flex-column add-margin-right">
                            <div class="user-comment-input-container flex-scale-auto"
                                 :class="[{'is-invalid-data': validated().name}]">
                                <div class="user-comment-input">
                                    <input class="input" placeholder="Name" v-model="user.name">
                                </div>
                            </div>
                            <div
                                class="general-input-validate-text-container">
                                <div class="inner" v-if="validated().name">
                                    <span class="span-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                 height="16" viewBox="0 0 24 24"
                                                                 fill="rgb(229, 28, 35)"><path
                                        d="M0 0h24v24H0z" fill="none"/><path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg></span>{{
                                    validated().name }}
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-scale-auto flex-column">
                            <div class="user-comment-input-container flex-scale-auto"
                                 :class="[{'is-invalid-data': validated().surname}]">
                                <div class="user-comment-input">
                                    <input class="input" placeholder="Surname" v-model="user.surname">
                                </div>
                            </div>
                            <div
                                class="general-input-validate-text-container">
                                <div class="inner" v-if="validated().surname">
                                    <span class="span-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                 height="16" viewBox="0 0 24 24"
                                                                 fill="rgb(229, 28, 35)"><path
                                        d="M0 0h24v24H0z" fill="none"/><path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg></span>{{
                                    validated().surname }}
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </Poster>
        </div>
        <div class="header-container">
            <div class="header-text-container">
                <span>Comments</span> ({{ comments.length }})
            </div>
            <div class="content-float-right"></div>
        </div>
        <div class="comments-user-container">
            <div class="comments-list">
                <!--Comment item -->
                <!--Guest Post Reply-->
                <CommentItem v-for="(item, idx) in comments"
                             :user="item"
                             :actions="item.comment_actions"
                             @onViewReplyShow="()=> item.comment.showReply = true"
                             @onCommentReply="commentReplyAction(item, idx)"
                             @onCommentEdit="commentEditAction(item, null, {row: idx, column: null})"
                             @onCommentDelete="commentDeleteAction(item, idx)"
                             :key="idx">
                    <div v-show="item.comment.showReply">
                        <!--reply comments -->
                        <CommentItem v-for="(jItem, jIdx) in item.replies" container-class="lv-1"
                                     :user="jItem"
                                     :actions="jItem.comment_actions"
                                     @onCommentReply="commentReplyAction(item, idx)"
                                     @onCommentEdit="commentEditAction(item, jItem, {row: idx, column: jIdx})"
                                     @onCommentDelete="commentDeleteAction(jItem, idx, jIdx)"
                                     :key="`child-${jIdx}`"/>
                        <!--reply comments -->
                    </div>
                    <Poster
                        :ref="`poster-${idx}`"
                        :isInValid="item.validated.text"
                        :isHidePoster="!item.comment.poster.active"
                        :state="item.comment.action"
                        :placeholder="item.comment.poster.placeholder"
                        :buttonText="item.comment.poster.buttonText"
                        :isHideButton="item.comment.poster.hideButton"
                        :ImageUrl="LoggedIn() ? `${baseUrl}${authUserInfo.thumb_image}` : `${baseUrl}/assets/images/user_profiles/gender-neutral-user-v1.png`"
                        :container-class="(item.comment.action==='edit' || item.comment.action ==='edit-reply') ? 'in-side-comment is-edit-comment': 'in-side-comment'"
                        @onPosterButtonClick="postComment(item, idx)"
                        v-model="item.comment.poster.text"
                        :key="`poster-${idx}`">

                        <template slot="poster-top" v-if="!LoggedIn()">

                            <div class="user-commenter-container flex guest-user in-side-comment">
                                <div class="flex flex-scale-auto flex-column add-margin-right">
                                    <div class="user-comment-input-container flex-scale-auto"
                                         :class="[{'is-invalid-data': item.validated.name}]">
                                        <div class="user-comment-input">
                                            <input class="input" placeholder="Name" v-model="item.comment.poster.name">
                                        </div>
                                    </div>
                                    <div
                                        class="general-input-validate-text-container">
                                        <div class="inner" v-if="item.validated.name">
                                    <span class="span-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                 height="16" viewBox="0 0 24 24"
                                                                 fill="rgb(229, 28, 35)"><path
                                        d="M0 0h24v24H0z" fill="none"/><path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg></span>{{
                                            item.validated.name }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-scale-auto flex-column">
                                    <div class="user-comment-input-container flex-scale-auto"
                                         :class="[{'is-invalid-data': item.validated.surname}]">
                                        <div class="user-comment-input">
                                            <input class="input" placeholder="Surname"
                                                   v-model="item.comment.poster.surname">
                                        </div>
                                    </div>
                                    <div
                                        class="general-input-validate-text-container">
                                        <div class="inner" v-if="item.validated.surname">
                                    <span class="span-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                 height="16" viewBox="0 0 24 24"
                                                                 fill="rgb(229, 28, 35)"><path
                                        d="M0 0h24v24H0z" fill="none"/><path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg></span>{{
                                            item.validated.surname }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <template slot="poster-bottom"
                                  v-if="item.comment.action==='edit' || item.comment.action ==='edit-reply'">
                            <div class="user-comment-edit-action-container flex">
                                <div class="edit-action flex is-left">
                                    <button class="button is-default" @click="commentActionCancel(item)">Cancel</button>
                                </div>
                                <div class="edit-action flex is-right">
                                    <button @click="updateComment(item)" class="button is-default is-active-comment">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </template>
                    </Poster>
                </CommentItem>

            </div>

            <!--See more comments -->
            <div class="see-more-comments flex">
                <div class="inner flex">
                    <a v-if="paginate.current_page * paginate.per_page < paginate.total"
                       class="see-more-comments-action" @click="getComments(paginate.current_page+1)"><span>View more comments</span></a>
                </div>
                <span
                    class="comment-counter flex">{{ comments.length }} of {{ paginate.total + insertedData.comment }}</span>
            </div>
            <!--Write a comment-->
            <div class="see-more-comments flex">
                <div class="inner flex">
                    <a class="see-more-comments-action" @click="focusCommentPoster"><span>Write a comment...</span></a>
                </div>
            </div>
            <!--See more comments -->
        </div>
    </div>
</template>

<script>
    import Poster from './CommentPoster.vue'
    import CommentItem from './CommentItem.vue'

    import {mapState, mapGetters, mapActions, mapMutations} from 'vuex'

    export default {
        name: "DictionaryComments",
        props: {
            dictionary_id: {
                required: true
            }
        },
        components: {
            Poster,
            CommentItem
        },
        data: () => ({
            ...mapGetters(['LoggedIn', 'validated']),
            user: {},
            localUser: {},
            firstLoad: true,
            isLoading: false,
            insertedData: {comment: 0, reply_comment: 0},
            paginate: {per_page: 12, data: [], current_page: 1, last_page: 0, total: 0},
            isChild: false,
            comments: [
                // {
                //     name: 'Blank Blanking',
                //     image: 'https://scontent.fbkk2-4.fna.fbcdn.net/v/t1.0-1/cp0/e15/q65/c0.0.56.56a/p56x56/13310483_1748126125456622_1520016868636271119_n.jpg?_nc_cat=106&efg=eyJpIjoidCJ9&_nc_ht=scontent.fbkk2-4.fna&oh=9a40eb78f192e43782562c5471dc904d&oe=5D47B805',
                //     comment: {
                //         type: 'guest',//quest, user
                //         text: 'ยังไม่มาอีก รอก่อนนะ ขาย P20 pro ให้เค้า 5,000 พอ เคนะ 555',
                //         created_ago: '13 mins',
                //         showReply: false,
                //         action: '',
                //         poster: {
                //             text: '',
                //             active: false,
                //             placeholder: 'Write a comment...',
                //             buttonText: 'Post',
                //             hideButton: false
                //         },
                //     },
                //     validated: {},
                //     comment_actions: {reply: true, edit: true, delete: true},
                //     replies: [
                //         {
                //             name: 'บุญประจง พิพัฒนกิจ',
                //             image: 'https://scontent.fbkk2-4.fna.fbcdn.net/v/t1.0-1/cp0/e15/q65/p48x48/53209776_1257002934449039_4076647326590959616_n.jpg?_nc_cat=101&efg=eyJpIjoidCJ9&_nc_ht=scontent.fbkk2-4.fna&oh=2aab8ee052c635516b1e2151f4a9a8cb&oe=5D110E94',
                //             comment: {
                //                 text: 'ยามิมาโฮ มาแล้วเย้ๆๆๆๆ',
                //                 created_ago: '43 secs',
                //                 showReply: false,
                //                 action: '',
                //                 poster: {
                //                     text: '',
                //                     active: false,
                //                     placeholder: 'Write a comment...',
                //                     buttonText: 'Post',
                //                     hideButton: false
                //                 },
                //             },
                //             validated: {},
                //             comment_actions: {reply: true, edit: true, delete: true},
                //         },
                //         {
                //             name: 'tutor4dev',
                //             image: 'https://scontent.fbkk1-5.fna.fbcdn.net/v/t1.0-0/p110x80/51781282_2061950733853201_4307721192795537408_n.png?_nc_cat=111&_nc_ht=scontent.fbkk1-5.fna&oh=c31d4bb7f91a02acb0c66d635ae5f5a7&oe=5D152AEE',
                //             comment: {
                //                 text: 'เหมือนฟังคลิบฝรั่งอ่านว่าแอ๊กซีออส ผมก็ไม่ชัวร์เหมือนกันนะครับ :P',
                //                 created_ago: '1 min',
                //                 showReply: false,
                //                 action: '',
                //                 poster: {
                //                     text: '',
                //                     active: false,
                //                     placeholder: 'Write a comment...',
                //                     buttonText: 'Post',
                //                     hideButton: false
                //                 },
                //             },
                //             validated: {},
                //             comment_actions: {reply: true, edit: true, delete: true},
                //         },
                //         {
                //             name: 'Seven Ninlavanh ',
                //             image: 'https://scontent.fbkk1-5.fna.fbcdn.net/v/t1.0-1/p48x48/49322408_2004089676312108_5227311486581342208_n.jpg?_nc_cat=102&_nc_ht=scontent.fbkk1-5.fna&oh=0a67842c476516921c741b5e537716a4&oe=5D06A5AB',
                //             comment: {
                //                 text: 'พี่ได้ทำ series ของการสอน vuejs ไว้บ้างใหมครับ',
                //                 created_ago: 'a sec',
                //                 showReply: false,
                //                 action: '',
                //                 poster: {
                //                     text: '',
                //                     active: false,
                //                     placeholder: 'Write a comment...',
                //                     buttonText: 'Post',
                //                     hideButton: false
                //                 },
                //             },
                //             validated: {},
                //             comment_actions: {reply: true, edit: true, delete: true},
                //         }
                //     ]
                // },
                // {
                //     name: 'Blank Blanking',
                //     image: 'https://scontent.fbkk2-4.fna.fbcdn.net/v/t1.0-1/cp0/e15/q65/p48x48/53209776_1257002934449039_4076647326590959616_n.jpg?_nc_cat=101&efg=eyJpIjoidCJ9&_nc_ht=scontent.fbkk2-4.fna&oh=2aab8ee052c635516b1e2151f4a9a8cb&oe=5D110E94',
                //     comment: {
                //         text: 'ยังไม่มาอีก รอก่อนนะ ขาย P20 pro ให้เค้า 5,000 พอ เคนะ 555', created_ago: '22 mins',
                //         showReply: false,
                //         action: '',
                //         poster: {
                //             text: '',
                //             active: false,
                //             placeholder: 'Write a comment...',
                //             buttonText: 'Post',
                //             hideButton: false
                //         },
                //     },
                //     validated: {},
                //     comment_actions: {reply: true, edit: true, delete: true},
                // },
                // {
                //     name: 'Blank Blanking',
                //     image: 'https://scontent.fbkk1-4.fna.fbcdn.net/v/t1.0-0/p110x80/49897341_2111206265766667_1476075698656378880_n.png?_nc_cat=101&_nc_ht=scontent.fbkk1-4.fna&oh=76a3c9ed8941a6e6015dc1f21965eb66&oe=5D080B20',
                //     comment: {
                //         text: 'ຫາກະຊື້ P20ບໍ່ຮອດປີ P30ອອກມາໃໝ່ອີກແລ້ວ555',
                //         created_ago: '43 mins',
                //         showReply: false,
                //         action: '',
                //         poster: {
                //             text: '',
                //             active: false,
                //             placeholder: 'Write a comment...',
                //             buttonText: 'Post',
                //             hideButton: false
                //         },
                //     },
                //     validated: {},
                //     comment_actions: {reply: true, edit: true, delete: true},
                // }
            ],
        }),
        computed: {
            ...mapState(['isMobile', 'authUserInfo', 'dictionaryComments']),
        },
        watch: {},
        methods: {
            ...mapActions(['deleteDictionaryComment', 'postMangeDictionaryComment', 'fetchDictionaryComments', 'showErrorToast', 'showInfoToast']),
            setUserLocal() {
                this.localUser = this.$utils.getLocalStorage('dictionary_comments_user');
                if (this.localUser) {//set local user
                    this.user = this.$utils.toJSON(this.localUser);
                    this.localUser = this.user;
                }
                //@for post comment
                this.user.id = '';
                this.user.comment = {};
                this.user.comment.action = 'post';
                //@for post comment
            },
            setPosterUser(item, idx) {
                this.setUserLocal();
                if (item.comment.action !== 'post') {
                    item.comment.poster.name = this.localUser ? this.localUser.name : item.comment.poster.name;
                    item.comment.poster.surname = this.localUser ? this.localUser.surname : item.comment.poster.surname;
                } else {
                    item.comment.poster.name = this.localUser ? this.localUser.name : this.user.name;
                    item.comment.poster.surname = this.localUser ? this.localUser.surname : this.user.surname;
                }
                let poster = this.$refs['poster-' + idx];
                if (poster && poster.length > 0) {
                    poster[0].setFocus();
                }
            },
            commentReplyAction(item, idx) {
                this.setPosterUser(item, idx);
                item.comment.action = 'reply';
                item.comment.poster.text = '';
                item.comment.poster.active = true;
                item.comment.showReply = true;
                item.comment.poster.placeholder = 'Write a reply...';
                item.comment.poster.buttonText = 'Reply';
                item.comment.poster.hideButton = false;
            },
            commentEditAction(item, child, pos) {
                if (child && pos) {
                    item.comment.action = 'edit-reply';
                    child.comment.action = 'edit-reply';
                    child.dictionary_id = this.dictionary_id;
                    item.child = {data: child, pos};
                    item.comment.poster.text = child.text;
                } else {
                    item.child = {};
                    item.comment.action = 'edit';
                    item.comment.poster.text = item.text;
                }
                this.setPosterUser(item, pos.row);
                item.comment.poster.active = true;
                item.comment.poster.placeholder = 'Update your comment...';
                item.comment.poster.hideButton = true;
            },
            commentActionCancel(item) {
                item.comment.action = '';
                item.comment.poster.text = '';
                item.comment.poster.active = false;
                item.comment.poster.placeholder = 'Write a comment...';
                item.comment.poster.hideButton = false;
            },
            commentDeleteAction(item, idx, jIdx = 0) {
                let c = confirm('Are you sure you want to delete this comment?');
                if (c) {
                    if (!this.LoggedIn()) {
                        item.id = String(item.hash_id).substring(0, 191);
                    }
                    if (item.isReplyComment) {
                        item.dictionary_id = this.dictionary_id;
                    }
                    this.isLoading = true;
                    this.deleteDictionaryComment(item)
                        .then(res => {
                            this.isLoading = false;
                            if (res.success) {
                                if (item.isReplyComment) {
                                    this.comments[idx].replies.splice(jIdx, 1);
                                    this.insertedData.reply_comment--;
                                    let cancel = this.comments[idx];
                                    this.commentActionCancel(cancel);
                                } else {
                                    this.comments.splice(idx, 1);
                                    this.insertedData.comment--;
                                }
                                //@remove deleted hash_ids
                                let hash_ids = this.$utils.getLocalStorage('dictionary_comments_hash_ids'), exists_data,
                                    new_data;
                                if (hash_ids) {
                                    exists_data = this.$utils.toJSON(hash_ids);
                                    new_data = this.$utils.removeArrayItem(exists_data.hash_ids, item.hash_id);
                                    this.$utils.setLocalStorage('dictionary_comments_hash_ids', JSON.stringify({hash_ids: new_data}));
                                }
                                //@remove deleted hash_ids
                            } else {
                                let text = item.isReplyComment ? 'reply comment' : 'comment';
                                this.showErrorToast({msg: `Failed to delete this ${text}.`, dt: 3500});
                            }
                        })
                        .catch(err => {
                            this.isLoading = false;
                        })
                }
            },
            focusCommentPoster() {
                let obj = this.$refs['main-poster'].$refs;
                obj[Object.keys(obj)[0]].focus();
            },
            setHashIds(hash_id) {//when created comment.
                return new Promise((r, j) => {
                    let hash_ids = this.$utils.getLocalStorage('dictionary_comments_hash_ids'), exists_data, dt = 300;
                    if (!hash_ids) {
                        this.$utils.setLocalStorage('dictionary_comments_hash_ids', JSON.stringify({hash_ids: [hash_id]}));
                        setTimeout(() => {
                            r({saved: true});
                        }, dt);
                    } else {
                        exists_data = this.$utils.toJSON(hash_ids);
                        if (exists_data.hash_ids.length <= 200) {
                            exists_data.hash_ids.push(hash_id);
                            this.$utils.setLocalStorage('dictionary_comments_hash_ids', JSON.stringify({hash_ids: exists_data.hash_ids}));
                            setTimeout(() => {
                                r({saved: true});
                            }, dt);
                        } else {
                            setTimeout(() => {
                                r({saved: false});
                            }, dt);
                        }
                    }
                });
            },
            postComment(data, idx) {
                let actions = {reply: true};
                data.loggedIn = this.LoggedIn();
                data.dictionary_id = this.dictionary_id;
                this.isLoading = true;
                if (actions[data.comment.action]) {
                    this.setPosterUser(data);
                }
                this.postMangeDictionaryComment(data)
                    .then(res => {
                        this.isLoading = false;
                        if (res.success) {
                            if (!data.loggedIn) {//if user loggedIn post id no need to add for security reason
                                this.setHashIds(res.comment.hash_id).then(d => {
                                    this.setInsertedItem(data, res, idx, d.saved);
                                });
                            } else {//for user
                                this.setInsertedItem(data, res, idx);
                            }
                            if (data.comment.action === 'post') {
                                this.insertedData.comment++;
                                this.user.text = '';
                            }
                        } else {
                            let text = data.comment.action === 'reply' ? 'reply comment' : 'comment';
                            this.showErrorToast({msg: `Failed to post the ${text}.`, dt: 3500});
                        }
                    })
                    .catch(err => {
                        this.isLoading = false;
                    })
            },
            setInsertedItem(data, res, idx, saved = true) {
                res.comment.comment_actions = {reply: true, edit: saved, delete: saved};
                if (data.comment.action === 'reply') {
                    this.insertedData.reply_comment++;
                    this.comments[idx].replies.push(res.comment);
                } else {
                    this.comments.unshift(res.comment);
                }
            },
            updateComment(data) {
                if (!this.LoggedIn() && data.comment.action === 'edit') {
                    data.id = String(data.hash_id).substring(0, 191);
                }
                data.loggedIn = this.LoggedIn();
                this.isLoading = true;
                this.postMangeDictionaryComment(data)
                    .then(res => {
                        this.isLoading = false;
                        if (res.success) {
                            if (data.comment.action === 'edit') {
                                data.text = res.comment.text;
                                data.comment.text = data.text;
                                data.comment.created_ago = res.comment.comment.created_ago;
                            } else {
                                let pos = data.child.pos, reply = this.comments[pos.row].replies[pos.column],
                                    comment = res.comment;
                                reply.text = comment.text;
                                reply.comment.text = reply.text;
                                reply.comment.created_ago = comment.comment.created_ago;
                            }
                            this.commentActionCancel(data);
                        } else {
                            let text = data.comment.action === 'edit' ? 'comment' : 'reply comment';
                            this.showErrorToast({msg: `Failed to update the ${text}.`, dt: 3500});
                        }
                    })
                    .catch(err => {
                        this.isLoading = false;
                    })
            },
            getComments(page = 1) {
                if (this.paginate.current_page === this.paginate.last_page && page !== 1) return;
                this.paginate.current_page = page;
                this.isLoading = true;
                this.fetchDictionaryComments({
                    firstLoad: this.firstLoad,
                    id: this.dictionary_id,
                    limit: this.paginate.per_page, page: this.paginate.current_page
                }).then(res => {
                    this.isLoading = false;
                    this.paginate = res.data;
                    if (this.firstLoad || page === 1) {
                        this.comments = res.data.data;
                        this.firstLoad = false;
                    } else {
                        this.comments = this.comments.concat(res.data.data);
                    }
                }).catch(err => {
                    this.isLoading = false;
                })
            }
        },
        created() {
            this.comments = this.dictionaryComments;
            this.setUserLocal();
            this.getComments();
        }
    }
</script>

<style scoped>
    /*comments section */

    .header-text-container {
        padding: 0 8px 11px;
        color: #777;
        display: inline-block;
        font-family: 'Google Sans', sans-serif;
        font-size: 16px;
    }

    .header-text-container span {
        color: #222;
        unicode-bidi: embed;
        direction: ltr;
    }

    .content-float-right {
        float: right;
    }

    .single-dictionary-comments-container {
        background-color: #fff;
        border: 1px solid #dadce0;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -ms-border-radius: 8px;
        border-radius: 8px;
        padding-top: 16px;
        padding-bottom: 8px;
        outline-width: 0;
        position: relative;
        margin-bottom: 8px;
    }

    .comments-user-container, .header-container {
        padding: 0 8px 8px;
    }

    .comments-list {
        unicode-bidi: embed;
    }

    .see-more-comments {
        justify-content: space-between;
        margin: 0 12px;
    }

    .see-more-comments .inner {
        padding-bottom: 8px;
        padding-top: 9px;
    }

    a.see-more-comments-action {
        font-size: 14px;
        color: #365898;
        flex: 1 1 auto;
    }

    .comment-counter {
        color: #606770;
        padding-bottom: 8px;
        padding-top: 9px;
    }

    .user-comment-poster {
        border-bottom: 1px solid rgba(6, 8, 21, 0.12);
        padding: 0 0 11px 0;
        margin-bottom: 12px;
    }

    /*comments section */
    /*Validate color */
    .user-comment-input-container.is-invalid-data {
        border: 2px solid #d93025;
    }

    .add-margin-right {
        margin-right: 10px;
    }

    /*Validate color*/
    /*@mediaScreen*/
    @media screen and (max-width: 719px) {
        .single-dictionary-comments-container {
            margin: 4px 4px;
            margin-bottom: 8px;
        }
    }

    /*@mediaScreen*/
</style>
