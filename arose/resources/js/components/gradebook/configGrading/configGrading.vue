<template>
    <section>
        <h1 class="h3">Config your gradebook with Rubrics.</h1>
        <h2 class="h4 mt-4">My created Rubrics</h2>
        <div class="alert alert-info" role="alert" v-if="loadingMyRubrics">
            Loading my rubrics...
        </div>
        <div class="alert alert-info" role="alert" v-else-if="myrubrics.length === 0">
            There's no rubrics created by you. You can create one on your own.
        </div>
        <div v-if="!loadingMyRubrics && !loadingUser">
            <config-grading-rubric-item
                :rubric="rubric"
                v-for="rubric in myrubrics"
                :key="rubric.id"
                :level="getLevel"
                :userid="userId"
            ></config-grading-rubric-item>
        </div>
        <h2 h2 class="h4 mt-4">Rubrics shared by Arose project</h2>
        <div class="alert alert-info" role="alert" v-if="loadingSharedRubrics">
            Loading shared Arose project rubrics...
        </div>
        <div v-if="!loadingSharedRubrics && !loadingUser">
            <config-grading-rubric-item
                :rubric="rubric"
                v-for="rubric in sharedrubrics"
                :key="rubric.id"
                :level="getLevel"
                :userid="userId"
            ></config-grading-rubric-item>
        </div>
    </section>
</template>

<script>
import ConfigGradingRubricItem from './ConfigGradingRubricItem.vue';
export default {
    name: 'ConfigGrading',
    components: {
        ConfigGradingRubricItem
    },
    computed: {
        getLevel() {
            return this.dividedByLevel ? this.activeLevel : '';
        }
    },
    data() {
        return {
            userId: null,
            activeLevel: '',
            dividedByLevel: false,
            loadingUser: false,
            loadingMyRubrics: false,
            loadingSharedRubrics: false,
            myrubrics: [],
            sharedrubrics: [],
            levels: ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'],
        }
    },
    mounted() {
        this.loadingMyRubrics = true;
        this.loadingSharedRubrics = true;
        this.loadingUser = true;
        axios.get('/gradebook/api/myself/')
          .then(response => {
              this.userId = response.data.id;
              // this.dividedByLevel = response.data.hasrubricsbygroups || false;
              this.dividedByLevel = false;
              this.loadingUser = false;
          });
        axios.get('/gradebook/api/myrubrics/')
          .then(response => {
              this.myrubrics = response.data;
              this.loadingMyRubrics = false;
          });
        axios.get('/gradebook/api/aroserubrics/')
          .then(response => {
            this.loadingSharedRubrics = false;
            this.sharedrubrics = response.data;
          });
    },
}
</script>
