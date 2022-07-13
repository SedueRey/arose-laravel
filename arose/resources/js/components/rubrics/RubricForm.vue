<template>
<div class="RubricForm">
    <div class="row">
        <div class="col-sm-6">
            <strong>Rubric max assignable points to student:
            {{ maxpoints }}
            <input type="hidden" name="maxpoints" id="maxpoints" v-model="maxpoints" />
            &nbsp;points</strong>
            <br />
            Rubric total points: {{ totalPoints }}
            <input type="hidden" name="rubricPoints" id="rubricPoints" v-model="totalPoints" />
        </div>
        <div class="col-sm-6">
            Your students will pass this rubrics with:
            <input
                type="number"
                name="passpoints"
                id="passpoints"
                class="form-control form-control-sm"
                v-model="passpoints" />
            &nbsp;&nbsp;points
        </div>
    </div>
    <div class="form-group">
        <h4><br /><label for="rubricTitle">Rubric title</label></h4>
        <input
            type="text"
            class="form-control form-control-sm"
            id="rubricTitle"
            name="rubricTitle"
            v-model="rubricTitle"
            required placeholder="Add your rubric title"
        >
    </div>
    <div class="form-check">
        <input class="form-check-input"
            type="checkbox"
            v-model="isPublic"
            name="isPublic"
            id="isPublic" />
        <label class="form-check-label" for="isPublic">
            I want to share this rubric with all Arose community
        </label>
    </div>
    <hr class="hr" />
    <button
        class="btn btn-primary btn-sm float-right"
        type="button"
        @click="addCriterion"
    >
        <i class="far fa-plus-square"></i> Add criterion
    </button>
    <h2 class="h4">Criteria</h2>
    <div class="alert alert-info" role="alert" v-if="criteria.length == 0">
        There are no criteria for this rubric. Feel free to append one clicking <em>"Add criterion"</em> button.
    </div>
    <p v-else>
        There are <strong class="text-primary">{{ criteria.length }}</strong> criteria for this rubric.
    </p>
    <rubric-criteria-form
        v-for="criterion in criteria" :key="criterion.uuid"
        :uuid="criterion.uuid"
        :criterion="criterion"
        @totalPoints="criterionPoints"
        @maxPoints="criterionMaxPoints"
        :old="old"
    >
        <button
            class="btn btn-warning btn-sm float-right remove-criterion"
            type="button"
            @click="deleteCriterion(criterion.uuid)"
        >
            <i class="fas fa-trash"></i> Remove criterion
        </button>
    </rubric-criteria-form>
</div>
</template>
<script>
import randomString from '../../utils/randomString';
import RubricCriteriaForm from './RubricCriteriaForm.vue';
export default {
    name: 'RubricForm',
    props: {
        old: { type: Object, required: false, default: {} },
    },
    data() {
        return {
            criteria: [],
            rubricTitle: '',
            passpoints: 0,
            isPublic: false,
        }
    },
    components: {
        RubricCriteriaForm,
    },
    computed: {
      totalPoints() {
        return this.criteria.reduce((a, b) => a + (b.points || 0), 0);
      },
      maxpoints() {
        return this.criteria.reduce((a, b) => a + (b.maxpoints || 0), 0);
      },
    },
    methods: {
        addCriterion() {
            this.criteria.push({
                uuid: randomString(32),
                title: '',
                description: '',
                points: 0,
                maxpoints: 0,
            })
        },
        deleteCriterion(uuid) {
            const removeIndex = this.criteria.findIndex( item => item.uuid === uuid );
            this.criteria.splice( removeIndex, 1 );
        },
        criterionPoints(value) {
            const criterion = this.criteria.find(el => el.uuid === value.uuid);
            criterion.points = value.points;
        },
        criterionMaxPoints(value) {
            const criterion = this.criteria.find(el => el.uuid === value.uuid);
            criterion.maxpoints = value.maxpoints || 0;
            console.log(value, criterion);
        }
    },
    mounted() {
        if (this.old !== null && this.old !== undefined) {
            if (this.old.rubricTitle) {
                this.rubricTitle = this.old.rubricTitle;
            }
            if (this.old.passpoints) {
                this.passpoints = this.old.passpoints;
            }
            if (this.old.maxpoints) {
                this.maxpoints = this.old.maxpoints;
            }
            if (this.old.isPublic) {
                this.isPublic = this.old.isPublic;
            }
            if (this.old.criteriatitle) {
                const criteriaUUids = Object.keys(this.old.criteriatitle);
                for(let i = 0; i < criteriaUUids.length; i++) {
                    const uuid = criteriaUUids[i];
                    this.criteria.push(
                    {
                        uuid: uuid,
                        title: (this.old.criteriatitle[uuid] || ''),
                        description: (this.old.criteriadescription[uuid] || ''),
                        points: 0,
                        maxpoints: 0,
                    }
                    );
                }
            }
        }
    },
}
</script>
