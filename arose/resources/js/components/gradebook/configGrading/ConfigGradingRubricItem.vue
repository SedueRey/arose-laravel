<template>
<article class="vuerubric" :class="isActive ? 'is-active' : ''">
    <p>
        <span>
            {{rubric.title}}
        </span>
        <nav class="float-right">
            <button
                @click="toggleIsShowingDetails"
                v-if="isShowingDetails"
                class="btn btn-light btn-sm"
            >
                <i class="fas fa-search-minus"></i> Hide criteria
            </button>
            <button
                @click="toggleIsShowingDetails"
                v-else
                class="btn btn-light btn-sm"
            >
                <i class="fas fa-search-plus"></i> Show criteria
            </button>
            <button
                @click="addToGradeBook"
                v-if="!isActive"
                class="btn btn-light btn-sm"
            >
                <i class="fas fa-user-plus"></i> Add to gradebook
            </button>
            <button
                @click="removeFromGradeBook"
                v-else
                class="btn btn-light btn-sm"
            >
                <i class="fas fa-user-plus"></i> Remove from gradebook
            </button>
        </nav>
    </p>
    <p>
        <small>{{rubric.points}} max total points, used {{ gradeTimes }} times for grading</small>
    </p>
    <span v-if="isShowingDetails">
    <div class="criterion is-small" v-for="criterion in rubric.criteria" :key="criterion.id">
        <h2 class="criterion__title">
        Criterion: {{ criterion.title }}
        </h2>
        <p class="mb-2">
            {{ criterion.description }}<br>
            <em>{{ criterion.ratings.length }} ratings</em>
        </p>
        <ul class="showratings" v-if="criterion.ratings.length > 0">
            <li class="showratings__item" v-for="rating in criterion.ratings" :key="rating.id">
                <em class="showratings__points float-right">
                    <strong class="text-primary">{{rating.points}}</strong>
                    points
                </em>
                <h3 class="criterion__title">{{rating.title}}</h3>
                <p>{{rating.description}}</p>
            </li>
        </ul>
    </div>
    </span>
</article>
</template>

<script>
export default {
    name: 'ConfigGradingRubricItem',
    props: {
        userid: { type: Number, required: true },
        rubric: { type: Object, required: true },
        level: { type: String, required: true },
    },
    data() {
        return {
            gradeTimes: 0,
            isShowingDetails: false,
            isActive: false,
        }
    },
    mounted() {
       this.gradeTimes = this.rubric.usedrubrics.length;
       this.isActive = this.rubric.usedrubrics.find(el =>
          (
              el.rubric_id === this.rubric.id &&
              `${el.user_id}` === `${this.userid}` &&
              el.level === this.level
          )
       );
    },
    methods: {
        toggleIsShowingDetails() {
            this.isShowingDetails = !this.isShowingDetails;
        },
        addToGradeBook() {
            this.isActive = true;
            this.gradeTimes = this.gradeTimes + 1;
            axios.post('/gradebook/api/setuserusedrubric', {
                level: this.level,
                rubricId: this.rubric.id,
            })/*.then(response => {
                console.info('ok');
            })*/;
        },
        removeFromGradeBook() {
            this.gradeTimes = this.gradeTimes - 1;
            this.isActive = false;
            axios.post('/gradebook/api/removeuserusedrubric', {
                level: this.level,
                rubricId: this.rubric.id,
            })/*.then(response => {
                console.info(ok);
            })*/;
        },
    },
}
</script>
