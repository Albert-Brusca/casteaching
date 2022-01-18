<template>
    <div>
        <a :href="'/manage/videos/' + video.id" class="text-indigo-600 hover:text-indigo-900">Edit</a>
    </div>
</template>

<script>
export default {
    name: "VideoEditLink",
    props: {
        video: {
            type: Object,
            required: true
        }
    }
}
</script>

<style scoped>

</style>
