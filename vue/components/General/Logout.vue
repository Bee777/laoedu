<template>
    <div>
        <div style="background-color: whitesmoke;" class="fire-spinner">Logging out...</div>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';

    export default {
        name: "Logout",
        methods: {
            ...mapActions(['Logout']),
        },
        created() {
            this.Logout({path: '/'});
        }
    }
</script>

<style scoped>

</style>
