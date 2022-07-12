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
        active: { type: Boolean, required: false, default: false },
    },
    methods: {
        toggleActive() {
            if (!this.isActive) {
                axios.post('/gradebook/api/setuserstudentusedrrating', {
                    student_id: this.student.id,
                    rating_id: this.rating.id,
                    criterion_id: this.rating.criterion_id
                }).then(response => {
                    this.$emit('activeRating', {
                        ratingId: this.rating.id,
                        criterionId: this.rating.criterion_id,
                    });
                    // this.$emit('message', `Rating ${this.rating.title} added to student successfully`);
                });
            } else {
                axios.post('/gradebook/api/removeuserstudentusedrrating', {
                    student_id: this.student.id,
                    rating_id: this.rating.id,
                }).then(response => {
                    this.$emit('removePoints', this.rating.id);
                    // this.$emit('message', `Rating ${this.rating.title} removed from student successfully`);
                });
            }
        }
    },
    computed: {
        isActive() {
            return this.active && this.student.ratings.findIndex(el => el.id === this.rating.id ) > -1;
        }
    },
    mounted() {
        if (this.isActive) {
            this.$emit('addPoints', this.rating.points);
        }
    },
}
</script>
