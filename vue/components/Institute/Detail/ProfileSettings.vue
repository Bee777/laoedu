<template>
    <div class="no-tip">
        <Tabs :bgColor="theme.bgColor" :offsetLeft="getSideBarWidthForTabs()" :tabs="tabs"/>
        <div class="module_content layout-column">
            <div class="module_authentication">
                <div class="module-canvas emails-card-wrapper">
                    <div class="md-single-grid">
                        <div ad-cell="12">
                            <div class="admin-canvas-bar">
                                <div class="admin-canvas-bar-container">
                                    <div class="admin-canvas-bar-section"> Profile Settings and Credential</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <MasterDetailCard :isLoading="isLoading" @onStateChanged="stateChanged">
                        <template slot="details">
                            <div class="details"
                                 :class="[{'is-edit': isEdit}]">
                                <MasterDetailCardItem :header='{ title: " Profile Settings " }'>
                                    <!--Profile settings start-->
                                    <MasterDetailCardMenu
                                        :selected="true"
                                        :header='{
                                    title: "My Profile",
                                    content: `<p> Changes your personal information such as First name, Last name, Profile picture, Major,  University of Graduation in Japan and so on.</p>`}'
                                        :menuItem='{name: "My Profile", icon: "account_circle", selected: true}'>
                                        <form @submit.prevent class="admin-form admin-template-form">
                                            <!--Personal Info -->
                                            <button v-if="!isEdit" @click="isEdit=true"
                                                    class="v-md-button v-md-icon-button edit-button"><i
                                                class="material-icons">edit</i></button>
                                            <button v-if="isEdit" @click="isEdit=false"
                                                    class="v-md-button v-md-icon-button edit-button"><i
                                                class="material-icons">close</i></button>
                                            <div class="admin-settings-cameo template-brand-settings">
                                                <div class="settings-container no-border-left" border-bottom>
                                                    <div class="cameo-header">
                                                        <i class="material-icons cameo-header-icon">account_box</i>
                                                        <span> Personal Information</span>
                                                    </div>
                                                    <div class="cameo-content">
                                                        <div class="layout-align-space-around-start layout-row">
                                                            <div class="form-input-container dense">
                                                                <label class="is-center"> Profile Picture </label>
                                                                <div class="user-picture-link-inner in-image-side-form"
                                                                     :class="[{'is-edit':isEdit }]"
                                                                     @click="chooseProfileImage">
                                                                    <div title="profile"
                                                                         class="user-picture-link-inner-title">
                                                                        <img style="width: 100%; height: 100%;"
                                                                             v-if="userProfile.profile_image_base64!==''"
                                                                             :src="`${userProfile.profile_image_base64}`">
                                                                        <img v-else
                                                                             :style="`${getImageStyleProfile()}`"
                                                                             :src="`${baseUrl}${authUserInfo.thumb_image}`">
                                                                    </div>
                                                                    <span v-if="isEdit"
                                                                          class="user-picture-link-change is-black">Change</span>
                                                                </div>
                                                                <AdminInput ref="profile-image" v-show="false"
                                                                            @inputImageBase64="(d)=>userProfile.profile_image_base64=d"
                                                                            @inputFile="(d)=> userProfile.profile_image=d"
                                                                            :inputType="'file'"/>
                                                                <div admin-messages
                                                                     v-if="validated().profile_image">
                                                                    <div admin-message class="message-required ">
                                                                        {{ validated().profile_image }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="layout-align-space-around-start layout-row">
                                                            <AdminInput :label="'Institute name'"
                                                                        v-model="userProfile.institute_name"
                                                                        :validateText="validated().institute_name"
                                                                        :containerClass="'dense'"
                                                                        :inputType="'text'">
                                                                <p class="template-tip">{{ userProfile.institute_name ||
                                                                    emptyText }}</p>
                                                            </AdminInput>
                                                            <AdminInput :label="' Short name '"
                                                                        v-model="userProfile.short_institute_name"
                                                                        :validateText="validated().short_institute_name"
                                                                        :containerClass="'is-second-input dense'"
                                                                        :inputType="'text'">
                                                                <p class="template-tip">{{ userProfile.short_institute_name ||
                                                                    emptyText }}</p>
                                                            </AdminInput>
                                                        </div>
                                                        <div class="layout-align-space-around-start layout-row">
                                                            <AdminInput :label="' Phone number '"
                                                                        v-model="userProfile.phone_number"
                                                                        :validateText="validated().phone_number"
                                                                        :containerClass="'dense'"
                                                                        :inputType="'text'">
                                                                <p class="template-tip">{{ userProfile.phone_number ||
                                                                    emptyText }}</p>
                                                            </AdminInput>
                                                            <div
                                                                class="form-input-container flex is-second-input dense"
                                                                full>
                                                                <label>Date of Founded</label>
                                                                <Datetime v-model="userProfile.dateOfBirth"
                                                                          value-zone="Asia/Vientiane"
                                                                          zone="Asia/Vientiane"
                                                                          format="dd-MM-yyyy"
                                                                          input-id="dateOfBirth"
                                                                          :input-class="'admin-input-datepicker'"/>
                                                                <p class="template-tip" v-if="userProfile.dateOfBirth">
                                                                    {{$utils.formatTimestmp(userProfile.dateOfBirth,
                                                                    false)}}</p>
                                                                <p class="template-tip" v-else>{{emptyText }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Personal Info-->
                                            <!--Marital Info -->
                                            <div class="admin-settings-cameo template-brand-settings">
                                                <div class="settings-container no-border-left no-margin-top"
                                                     border-bottom>
                                                    <div class="cameo-header">
                                                        <i class="material-icons cameo-header-icon">favorite</i>
                                                        <span> Marital Status</span>
                                                    </div>
                                                    <div class="cameo-content">
                                                        <div class="layout-align-space-around-start layout-row">
                                                            <div
                                                                class="form-multi-select-container flex dense"
                                                                full>
                                                                <label>Current Status</label>
                                                                <multiselect class="select-multiple"
                                                                             v-model="userProfile.marital_status"
                                                                             label="text" track-by="value"
                                                                             placeholder="Select your status"
                                                                             open-direction="bottom"
                                                                             :options="getMaritalStatusOption()"
                                                                             :show-no-results="false"
                                                                             :preserve-search="true"
                                                                             :hide-selected="false">
                                                                </multiselect>
                                                                <p class="template-tip">{{ (userProfile.marital_status && userProfile.marital_status.text) || emptyText }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Marital Info -->
                                            <!--Education Info -->
                                            <EducationProfile @onSaved="()=> reFetchData('member_educations')" :yearsOptions="getYearsOption(10)" :options="options" :isEdit="isEdit" :emptyText="emptyText" :member_educations="userProfile.member_educations"/>
                                            <!--Education Info-->

                                            <!--Career Info -->
                                            <CareerProfile @onSaved="()=> reFetchData('member_careers')" :yearsOptions="getYearsOption(18)" :options="options" :isEdit="isEdit" :emptyText="emptyText" :member_careers="userProfile.member_careers"/>
                                            <div class="admin-settings-cameo template-brand-settings">
                                                <div class="settings-container no-border-left no-margin-top">
                                                    <div class="cameo-header">
                                                        <i class="material-icons cameo-header-icon">business</i>
                                                        <span> Address Information & Description</span>
                                                    </div>
                                                    <div class="cameo-content">
                                                        <div class="layout-align-space-around-start layout-row">
                                                            <AdminInput :label="' Place of Birth '"
                                                                        v-model="userProfile.placeOfBirth"
                                                                        :containerClass="'dense'"
                                                                        :inputType="'text'">
                                                                <p class="template-tip">{{ userProfile.placeOfBirth ||
                                                                    emptyText }}</p></AdminInput>
                                                        </div>
                                                        <div class="layout-align-space-around-start layout-row">
                                                            <AdminInput
                                                                :label="' Place of Resident '"
                                                                v-model="userProfile.placeOfResident"
                                                                :containerClass="'dense'"
                                                                :inputType="'text'"><p class="template-tip">{{
                                                                userProfile.placeOfResident ||
                                                                emptyText }}</p></AdminInput>
                                                        </div>
                                                        <div class="layout-align-space-around-start layout-row"
                                                             v-if="!isEdit">
                                                            <AdminInput
                                                                :label="'Personal Description'"
                                                                :containerClass="'dense'"
                                                                :inputType="'textarea'">
                                                                <p class="template-tip"
                                                                   v-if="userProfile.personalDescription"
                                                                   v-html="userProfile.personalDescription"></p>
                                                                <p class="template-tip"
                                                                   v-else>{{ emptyText
                                                                    }}</p>
                                                            </AdminInput>
                                                        </div>
                                                        <div class="layout-align-space-around-start layout-row"
                                                             v-show="isEdit">
                                                            <Editor
                                                                id="description_jaol_editor"
                                                                v-model="userProfile.personalDescription"
                                                                :containerClass="'dense'"
                                                                label="Personal Description"
                                                                @editorMounted="(ed)=> editor = ed"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Address Info and Description-->
                                            <!--Actions Profile-->
                                            <div class="actions" v-if="isEdit">
                                                <div class="layout-align-end-center layout-row">
                                                    <button @click="isEdit=false"
                                                            class="v-md-button secondary">
                                                        Cancel
                                                    </button>
                                                    <button @click="saveProfileSettings" class="v-md-button primary">
                                                        Save
                                                        Changes
                                                    </button>
                                                </div>
                                            </div>
                                            <!--Actions Profile-->
                                        </form>
                                    </MasterDetailCardMenu>
                                    <!--Profile settings end-->

                                    <!--Credentials Start-->
                                    <MasterDetailCardMenu
                                        :header='{
                                    title: "Credentials",
                                    content: `<p> You can change your password or even your email address, both use to login to Jaol site, <strong>When you have changed your credentials please use the new credentials to login to Jaol Site</strong>.<br><strong>Note: Please use truly email address</strong>.</p>`}'
                                        :menuItem='{name: "Credentials", icon: "email", selected: false}'>
                                        <form @submit.prevent class="admin-form admin-template-form" novalidate>

                                            <button v-if="!isEdit" @click="isEdit=true"
                                                    class="v-md-button v-md-icon-button edit-button"><i
                                                class="material-icons">edit</i></button>
                                            <button v-if="isEdit" @click="isEdit=false"
                                                    class="v-md-button v-md-icon-button edit-button"><i
                                                class="material-icons">close</i></button>

                                            <div class="admin-settings-cameo template-brand-settings">
                                                <div class="settings-container add-padding">
                                                    <div class="cameo-header">
                                                        <i class="material-icons cameo-header-icon">settings</i>
                                                        <span> Credentials Information</span>
                                                    </div>
                                                    <div class="cameo-content">
                                                        <div class="layout-align-space-around-start layout-row">
                                                            <AdminInput :label="'New Email '"
                                                                        :validateText="validated().new_email"
                                                                        v-model="userCredential.new_email"
                                                                        :containerClass="'dense'"
                                                                        :inputType="'email'">
                                                                <p class="template-tip">New Email</p>
                                                            </AdminInput>
                                                        </div>
                                                        <div class="layout-align-space-around-start layout-row">
                                                            <AdminInput :label="'New Password '"
                                                                        :validateText="validated().new_password"
                                                                        v-model="userCredential.new_password"
                                                                        :containerClass="'dense'"
                                                                        :inputType="'password'">
                                                                <p class="template-tip">New Password</p>
                                                            </AdminInput>
                                                        </div>
                                                        <div
                                                            v-if="isEdit && !$utils.isEmptyVar(userCredential.new_password)"
                                                            class="layout-align-space-around-start layout-row">
                                                            <AdminInput :label="'New Password Confirmation'"
                                                                        :validateText="validated().new_password_confirmation"
                                                                        v-model="userCredential.new_password_confirmation"
                                                                        :containerClass="'dense'"
                                                                        :inputType="'password'">
                                                            </AdminInput>
                                                        </div>
                                                        <div v-if="getStateCredentialsChanges()"
                                                             class="layout-align-space-around-start layout-row">
                                                            <AdminInput :label="'Current Password '"
                                                                        :validateText="validated().current_password"
                                                                        v-model="userCredential.current_password"
                                                                        :containerClass="'dense'"
                                                                        :inputType="'password'">
                                                            </AdminInput>
                                                        </div>
                                                        <div v-if="getStateCredentialsChanges()"
                                                             class="layout-align-space-around-start layout-row">
                                                            <AdminInput :label="'Logout from all other devices'"
                                                                        :containerClass="'dense'"
                                                                        v-model="userCredential.logout_from_all_other_devices"
                                                                        :inputType="'checkbox'">
                                                            </AdminInput>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="actions"
                                                 v-if="getStateCredentialsChanges()">
                                                <div class="layout-align-end-center layout-row">
                                                    <button @click="isEdit=false"
                                                            class="v-md-button secondary">
                                                        Cancel
                                                    </button>
                                                    <button @click="saveUserCredentials" class="v-md-button primary">
                                                        Save Changes
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </MasterDetailCardMenu>
                                    <!--Reset Password end-->
                                </MasterDetailCardItem>
                                <!-- <MasterDetailCardItem :header='{ title: " SMS " }'>
                                    <MasterDetailCardMenu
                                        :header='{
                                        title: "การยืนยันทาง SMS",
                                        content: `อนุญาตให้ผู้ใช้ลงชื่อเข้าใช้ด้วยรหัสผ่านแบบใช้ครั้งเดียวที่ส่งเป็น SMS ไปยังโทรศัพท์มือถือ`}'
                                        :menuItem='{name: "การยืนยันที่อยู่อีเมล", icon: "email", selected: true}'>
                                        <form @submit.prevent class="admin-form admin-template-form">
                                            <div class="layout-align-space-around-start layout-row">
                                                <AdminInput
                                                    :value="'%LOGIN_CODE% is your verification code for %APP_NAME%.'"
                                                    :label="' ข้อความ '"
                                                    :inputType="'text'"/>
                                            </div>
                                            <div class="actions">
                                                <div class="layout-align-end-center layout-row">
                                                    <button class="v-md-button secondary"> ยกเลิก</button>
                                                    <button class="v-md-button primary"> บันทึก</button>
                                                </div>
                                            </div>
                                        </form>
                                    </MasterDetailCardMenu>
                                </MasterDetailCardItem> -->
                            </div>
                        </template>
                    </MasterDetailCard>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions} from 'vuex'
    import UserBase from '@bases/InstituteBase.js'
    import EducationProfile from '@com/User/Member/EducationProfile.vue'
    import CareerProfile from '@com/User/Member/CareerProfile.vue'

    export default UserBase.extend({
        name: "ProfileSettings",
        data: () => ({
            title: 'My Profile Settings',
            tabs: [{name: 'Profile Settings'}],
            userCredential: {},
            isEdit: false,
            editor: null,
            member: {educations: [], careers: []},
        }),
        components: {
            EducationProfile,
            CareerProfile
        },
        watch: {
            isEdit: function (n, o) {
                if (!n) {
                   this.resetMemberData();
                }
            }
        },
        methods: {
            ...mapActions(['postManageUserProfile', 'postChangeCredentialsUser']),
            resetMemberData() {
                this.setClearValidate(this.userProfile);
                this.setClearValidate(this.userCredential);
                this.getOptions(false);
                this.userCredential = {};
            },
            reFetchData(type){
                this.fetchOptionProfileData()
                    .then(res => {
                        let s = res.success, d = res.data, op = this.options;
                        if (s) {
                            op.organization = d.organizes;
                            op.workCategories = d.departments;
                            op.educationDegrees = d.education_degrees;
                            if (!this.$utils.isEmptyVar(d.user_profile)) {
                                this.userProfile[type] = d.user_profile[type];
                            }
                            this.fetchAuthUserInfo();
                        }
                    })
                    .catch(err => {})
            },
            stateChanged() {
                this.isEdit = false;
                this.resetMemberData();
            },
            getStateCredentialsChanges() {
                return this.isEdit && (!this.$utils.isEmptyVar(this.userCredential.new_email) || !this.$utils.isEmptyVar(this.userCredential.new_password))
            },
            getImageStyleProfile() {
                return (this.getImageProfileExt() === 'svg' || this.getImageProfileExt() === 'gif') ? `width: 100%; height: 100%` : ''
            },
            getImageProfileExt() {
                return this.$utils.getFileExtension(this.authUserInfo.thumb_image);
            },
            getMemberState() {
                let mbs = this.userProfile.memberOfState;
                return mbs === true || mbs === false || mbs === 'true';
            },
            chooseProfileImage() {
                if (this.isEdit) {
                    this.$refs['profile-image'].triggerInputClick();
                }
            },
            saveProfileSettings() {
                let dt = 3500;
                this.isLoading = true;
                this.postManageUserProfile(this.userProfile)
                    .then(res => {
                        if (res.success) {
                            this.showInfoToast({msg: 'Your profile was updated!', dt});
                            this.getOptions();
                            this.isEdit = false;//collapsed editing
                        }
                        this.isLoading = false;
                    })
                    .catch(err => {
                        this.showErrorToast({msg: 'Failed to update your profile!', dt});
                        this.isLoading = false;
                    })
            },
            saveUserCredentials() {
                let dt = 3500;
                this.isLoading = true;
                this.postChangeCredentialsUser(this.userCredential)
                    .then(res => {
                        if (res.success) {
                            this.getOptions();
                            this.showInfoToast({msg: 'Your credentials was updated!', dt});
                        } else {
                            this.showErrorToast({msg: 'Failed to update your credentials!', dt});
                        }
                        this.isLoading = false;
                    })
                    .catch(err => {
                        this.showErrorToast({msg: 'Failed to update your credentials!', dt});
                        this.isLoading = false;
                    });
            }
        },
        created() {
            this.getOptions();
        },
    });
</script>
