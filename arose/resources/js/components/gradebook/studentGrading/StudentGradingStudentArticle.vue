<template>
    <article v-if="student" class="studentrubric">
        <div class="studentrubric__header" :class="isExpanded ? 'expanded': 'unexpanded'">
            <span class="float-right text-right text-light">
                <span class="btn" @click="toggleExpand" v-if="isExpanded"><i class="fas fa-chevron-up"></i></span>
                <span class="btn" @click="toggleExpand" v-else><i class="fas fa-chevron-down"></i></span>
            </span>
            <span class="studentrubric__name">
                <span class="text-primary">{{ student.name }}</span>
                <small>(English level to grade: {{ student.level }})</small>
            </span>
            <strong class="studentrubric__points">{{points}} / {{ maxPoints }} points</strong>
        </div>
        <div v-if="isExpanded">
        <div class="studentrubric__rubric studentusedrubric" v-for="used in rubrics" :key="used.id">
            <span class="studentusedrubric__title">{{ used.rubric.title }}</span>
            <div class="studentusedcriteria" v-for="criteria in used.rubric.criteria" :key="criteria.id">
                <span class="studentusedcriteria__title">{{ criteria.title }}</span>
                <span class="studentusedcriteria__description">{{ criteria.description }}</span>
                <div class="studentratings">
                    <student-grading-rating
                        v-for="rating in criteria.ratings" :key="rating.id"
                        :rating="rating"
                        :student="student"
                        @removePoints="removePoints"
                        @addPoints="addPoints"
                    >
                    </student-grading-rating>
                </div>
            </div>
        </div>
        </div>
    </article>
</template>

<script>
import StudentGradingRating from './StudentGradingRating.vue';

export default {
    name: 'StudentGradingStudentArticle',
    components: {
        StudentGradingRating,
    },
    props: {
        rubrics: { type: Array, required: true },
        student: { type: Object, required: true },
    },
    data() {
        return {
            isExpanded: true,
            points: 0,
        }
    },
    computed: {
        maxPoints() {
            if (this.rubrics.length === 0) {
                return 0
            } else {
                const maprubrics = this.rubrics.map(el => el.rubric.points);
                return maprubrics.reduce((a, b) => a + b, 0);
            }
        }
    },
    methods: {
        toggleExpand() {
            this.isExpanded = !this.isExpanded;
        },
        addPoints(points) {
            this.points = this.points + points;
        },
        removePoints(points) {
            this.points = this.points - points;
        },
    },
}
</script>
