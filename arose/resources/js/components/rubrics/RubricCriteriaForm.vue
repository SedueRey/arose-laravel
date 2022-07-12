<template>
  <div class="criterion">
    <div class="row">
      <div class="col-sm-12">
        Criteria points: <strong>{{ totalPoints }}</strong>
        <slot></slot>
      </div>
    </div>
    <div class="form-group row">
      <label :for="`criteriatitle[${uuid}]`" class="col-sm-3 col-form-label"
        >Criteria title <i class="far fa-edit"></i
      ></label>
      <div class="col-sm-9">
        <input
          type="text"
          required
          class="form-control"
          :id="`criteriatitle[${uuid}]`"
          :name="`criteriatitle[${uuid}]`"
          v-model="usingCriterion.title"
        />
      </div>
    </div>
    <div class="form-group row">
      <label
        :for="`criteriadescription[${uuid}]`"
        class="col-sm-3 col-form-label"
        >Criteria description <i class="far fa-edit"></i
      ></label>
      <div class="col-sm-9">
        <input
          type="text"
          class="form-control"
          :id="`criteriadescription[${uuid}]`"
          :name="`criteriadescription[${uuid}]`"
          v-model="usingCriterion.description"
        />
      </div>
    </div>
    <hr />
    <button
      class="btn btn-primary btn-sm float-right"
      type="button"
      @click="addRating"
    >
      <i class="far fa-plus-square"></i> Add rating
    </button>
    <h3 class="h5">Edit rating titles and points</h3>
    <div class="alert alert-info" role="alert" v-if="ratings.length == 0">
      There are no ratings for this criterion. Feel free to append one clicking
      <em>"Add rating"</em> button.
    </div>
    <p v-else>
      There are
      <strong class="text-primary">{{ ratings.length }}</strong> ratings for
      this criterion.
    </p>
    <rubric-rating-form
      v-for="rating in ratings"
      :rating="rating"
      :key="rating.uuid"
      :uuid="uuid"
      @points="pointsEvent"
    >
      <button
        class="btn btn-primary btn-sm"
        type="button"
        @click="deleteRating(rating.uuid)"
      >
        <i class="fas fa-trash"></i> Remove this rating
      </button>
    </rubric-rating-form>
  </div>
</template>

<script>
import randomString from "../../utils/randomString";
import RubricRatingForm from "./RubricRatingForm.vue";

export default {
  name: "RubricCriteriaForm",
  components: {
    RubricRatingForm,
  },
  props: {
    criterion: { type: Object, required: true },
    uuid: { type: String, required: true },
    old: { type: Object, required: true, default: {} },
  },
  data() {
    return {
      usingCriterion: {},
      ratings: [],
    };
  },
  computed: {
    totalPoints() {
      const total = this.ratings.reduce(
        (a, b) => a + (b.points || 0), 0
      );
      this.$emit("totalPoints", {
        uuid: this.uuid,
        points: total,
      });
      this.$emit("maxPoints", {
        uuid: this.uuid,
        maxpoints: this.maxPoints,
      });
      return total;
    },
    maxPoints() {
        let max = 0;
        this.ratings.forEach(element => {
            if (element.points > max) {
                max = element.points
            }
        });
        return max;
    }
  },
  methods: {
    addRating() {
      this.ratings.push({
        uuid: randomString(32),
        title: "",
        points: 0,
        description: "",
      });
    },
    deleteRating(ratingid) {
      const removeIndex = this.ratings.findIndex(
        (item) => item.uuid === ratingid
      );
      this.ratings.splice(removeIndex, 1);
    },
    pointsEvent(value) {
      const rating = this.ratings.find((el) => el.uuid === value.uuid);
      rating.points = value.points;
    },
  },
  mounted() {
    this.usingCriterion = {...this.criterion};
    if (this.old !== null && this.old !== undefined) {
        if (this.old.ratingtitle && this.old.ratingtitle[this.uuid]) {
            const uuids = Object.keys(this.old.ratingtitle[this.uuid]) || [];
            for(let i = 0; i < uuids.length; i++) {
                const uuid = uuids[i];
                const prePoints = this.old.ratingpoints[this.uuid][uuid];
                const points = isNaN(prePoints) ? (
                    parseFloat(this.old.ratingpoints[this.uuid][uuid].replace(',', '.')) || 0
                ) : prePoints;
                this.ratings.push(
                {
                    uuid: uuid,
                    title: (this.old.ratingtitle[this.uuid][uuid] || ''),
                    description: (this.old.ratingdescription[this.uuid][uuid] || ''),
                    points: (points || 0),
                }
                );
            }
        }
    }
  },
};
</script>
