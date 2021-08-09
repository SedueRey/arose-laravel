<template>
    <span
        v-if="rating"
        :class="isActive ? 'active' : ''"
        class="studentratings__rating"
        @click="toggleActive"
    >
        <span class="studentratings__title">
            {{rating.title}}
        </span>
        <span
            class="studentratings__points"
            :class="isActive ? 'text-success': 'text-primary'"
        >
            <span v-if="isActive">{{rating.points}}</span>
            <span v-else>0</span>
            / {{rating.points}} points</span>
        <span class="studentratings__description">
            {{rating.description}}
        </span>
    </span>
</template>

<script>
export default {
    name: 'StudentGradingRating',
    props: {
        rating: { type: Object, required: true },
        student: { type: Object, required: true },
    },
    data() {
        return {
            isActive: false,
        }
    },
    methods: {
        toggleActive() {
            this.isActive = !this.isActive;
            if (this.isActive) {
                this.$emit('addPoints', this.rating.points);
                axios.post('/gradebook/api/setuserstudentusedrrating', {
                    student_id: this.student.id,
                    rating_id: this.rating.id,
                }).then(response => {
                    console.info(response);
                });
            } else {
                this.$emit('removePoints', this.rating.points);
                axios.post('/gradebook/api/removeuserstudentusedrrating', {
                    student_id: this.student.id,
                    rating_id: this.rating.id,
                }).then(response => {
                    console.info(response);
                });
            }
        }
    },
    mounted() {

    },
}
</script>
