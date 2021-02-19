<template>
    <div>
        <h4>Hello from Images App</h4>
        <div v-for="image of images" :key="image">
            <img :src="image">
        </div>
    </div>
</template>

<script>
export default {
    created() {
        this.fetchImages();
    },

    data() {
        return {
            images: [],
        }
    },

    methods: {
        fetchImages() {
            axios
                .get('/api/random-dog')
                .then(({data}) => this.images = data);
        }
    }
}

</script>
