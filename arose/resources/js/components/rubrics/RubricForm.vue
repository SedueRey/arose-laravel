<template>
<div class="RubricForm" v-if="old">
    <div class="row">
        <div class="col-sm-12">
            Rubric total points: {{ totalPoints }}
        </div>
    </div>
    <div class="form-group">
        <label for="rubricTitle">Rubric title</label>
        <input type="text" class="form-control form-control-sm" id="rubricTitle" name="rubricTitle" value="" required placeholder="Add your rubric title">
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
    <pre>{{ old }}</pre>
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
        }
    },
    components: {
        RubricCriteriaForm,
    },
    computed: {
      totalPoints() {
        return this.criteria.reduce((a, b) => a + (b.points || 0), 0);
      },
    },
    methods: {
        addCriterion() {
            this.criteria.push({
                uuid: randomString(32),
                title: '',
                description: '',
                points: 0,
            })
        },
        deleteCriterion(uuid) {
            const removeIndex = this.criteria.findIndex( item => item.uuid === uuid );
            this.criteria.splice( removeIndex, 1 );
        },
        criterionPoints(value) {
            const criterion = this.criteria.find(el => el.uuid === value.uuid);
            criterion.points = value.points;
        }
    },
    mounted() {
        if (this.old !== null && this.old !== undefined) {
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
                    }
                    );
                }
            }
        }
    },
}
</script>
