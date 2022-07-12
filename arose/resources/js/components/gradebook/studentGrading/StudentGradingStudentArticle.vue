<template>
    <article v-if="usedStudent" class="studentrubric">
        <div
            class="studentrubric__header"
            :class="isExpanded ? 'expanded': 'unexpanded'"
            @click="toggleExpand"
        >
            <span class="float-right text-right text-light">
                <span class="btn" v-if="isExpanded"><i class="fas fa-chevron-up"></i></span>
                <span class="btn" v-else><i class="fas fa-chevron-down"></i></span>
            </span>
            <span class="studentrubric__name">
                <span class="text-primary">{{ student.name }} {{ student.surname }}</span>
                <small>(English level to grade: {{ student.level }})</small>
                <small v-if="student.group">, Group: {{ student.group }}</small>
                <small v-if="student.class">, Class: {{ student.class }}</small>
            </span>
            <small class="studentrubric__points">
                <strong>
                {{points}} / {{ maxPoints }}
                </strong>
                (should be {{ maxUserPoints }} tops),
                the student will pass with <em>{{ passPoints }}</em>
            </small>
        </div>
        <div v-show="isExpanded">
        <div class="studentrubric__rubric studentusedrubric" v-for="used in usedRubrics" :key="used.id">
            <span class="studentusedrubric__title">{{ used.rubric.title }}</span>
            <div class="studentusedcriteria" v-for="criteria in used.rubric.criteria" :key="criteria.id">
                <span class="studentusedcriteria__title">{{ criteria.title }}</span>
                <span class="studentusedcriteria__description">{{ criteria.description }}</span>
                <div class="studentratings">
                    <student-grading-rating
                        v-for="rating in criteria.ratings" :key="rating.id"
                        :rating="rating"
                        :student="usedStudent"
                        :active="isActive(rating.id)"
                        @removePoints="removePoints"
                        @addPoints="addPoints"
                        @message="message"
                        @activeRating="activeRating"
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
            isExpanded: false,
            points: 0,
            active: null,
            usedRubrics: [],
            usedStudent: null,
        }
    },
    mounted() {
        this.usedRubrics = [...this.rubrics]
        this.usedStudent = {...this.student}
    },
    computed: {
        maxPoints() {
            if (this.rubrics.length === 0) {
                return 0
            } else {
                const maprubrics = this.rubrics.map(el => el.rubric.points);
                return maprubrics.reduce((a, b) => a + b, 0);
            }
        },
        maxUserPoints() {
            if (this.rubrics.length === 0) {
                return 0
            } else {
                const maprubrics = this.rubrics.map(el => el.rubric.maxpoints);
                return maprubrics.reduce((a, b) => a + b, 0);
            }
        },
        passPoints() {
            if (this.rubrics.length === 0) {
                return 0
            } else {
                const maprubrics = this.rubrics.map(el => el.rubric.passpoints);
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
        removePoints(ratingId) {
            this.points = this.points - this.getSinglePoints(ratingId);
            const usedBak = JSON.parse(JSON.stringify({...this.usedStudent}));
            this.usedStudent = null;
            usedBak.ratings = [...usedBak.ratings.filter(
                rating => rating.id !== ratingId
            )];
            this.usedStudent = JSON.parse(JSON.stringify(usedBak));
        },
        message(msg) {
            this.$emit('message', msg);
        },
        isActive(rating_id) {
            return this.usedStudent.ratings.findIndex(el => el.id === rating_id ) > -1
        },
        getSinglePoints(rating_id) {
            let points = 0;
            this.usedRubrics.forEach(
                el => {
                    el.rubric.criteria.forEach(
                        c => {
                            const rat = c.ratings.find(
                                r => r.id === rating_id
                            );
                            if (rat && rat.points !== 0 && rat.points !== points) {
                                points = rat.points;
                            }
                        }
                    )
                }
            )
            return points;
        },
        activeRating(data) {
            const userId = this.usedStudent.id
            const usedBak = JSON.parse(JSON.stringify({...this.usedStudent}));
            this.usedStudent = null;
            usedBak.ratings = [...usedBak.ratings.filter(
                rating => rating.criterion_id !== data.criterionId
            )];
            usedBak.ratings.push({
                id: data.ratingId,
                criterion_id: data.criterionId,
                points: this.getSinglePoints(data.ratingId),
                pivot: {
                    rating_id: data.ratingId,
                    student_id: userId
                }
            });
            let puntos = 0;
            usedBak.ratings.forEach(el => {
                if (el.points) {
                    puntos+=el.points
                }
            });
            this.points = puntos;
            this.usedStudent = JSON.parse(JSON.stringify(usedBak));
        },
    },
}
</script>
