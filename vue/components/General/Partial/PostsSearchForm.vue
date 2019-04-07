<template>
    <div class="search">
        <div class="form">
            <div class="field has-addons">
                <div class="control">
                    <input @keyup.enter="triggerButton" v-model="inputText" class="input is-medium" type="text"
                           placeholder="Find what you want">
                </div>
                <div class="control">
                    <a ref="search-button" @click="searchEnter" class="button is-info is-medium">
                        Search
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PostsSearchForm",
        data: () => ({
            inputText: '',
        }),
        props: {
            value: {}
        },
        watch: {
            inputText: function (n, o) {
                this.emits();
            }
        },
        methods: {
            emits() {
                this.$emit('send', this.inputText);
                this.$emit('input', this.inputText);
            },
            searchEnter() {
                this.$emit('onSearchEnter', this.inputText)
            },
            triggerButton() {
                this.$refs['search-button'].click();
                this.$utils.hideKeyboard(this.$refs['search-button']);
            }
        },
        mounted() {
            this.inputText = this.value;
        }
    };
</script>

<style scoped>

</style>
