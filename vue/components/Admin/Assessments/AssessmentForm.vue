<template>
    <div class="form-create-wrap">
        <div class="wrap">
            <div class="content-wrap">
                <div class="item title title-focus main-form">
                    <div class="li main-form">
                        <textarea class="form-title no-resize"
                                  placeholder="Assessment title"
                                  v-model="assessment.title"
                                  @focus="$autoText($event)"
                                  @input="$autoText($event)"
                                  @keypress.enter="$disableEnterNewLine"></textarea>
                    </div>
                    <div class="li main-form">
                        <textarea placeholder="Assessment description (optional)"
                                  v-model="assessment.description"
                                  @focus="$autoText($event)"
                                  @input="$autoText($event)"></textarea>
                    </div>

                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AssessmentForm",
        data: () => ({
            assessment: {},
        })
    }
</script>

<style scoped>

</style>
