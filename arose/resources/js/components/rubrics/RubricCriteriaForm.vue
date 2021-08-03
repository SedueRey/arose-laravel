<template>
  <div class="criterion" v-if="criterion">
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
          :value="criterion.title"
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
          required
          class="form-control"
          :id="`criteriadescription[${uuid}]`"
          :name="`criteriadescription[${uuid}]`"
          :value="criterion.description"
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
      ratings: [],
    };
  },
  computed: {
    totalPoints() {
      const total = this.ratings.reduce((a, b) => a + (b.points || 0), 0);
      this.$emit("totalPoints", {
        uuid: this.uuid,
        points: total,
      });
      return total;
    },
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
      /*const rating = this.ratings.find((el) => el.uuid === value.uuid);
      rating.points = value.points;*/
    },
  },
  mounted() {
    // Adaptar para arrays de 2 dimensiones

    if (this.old !== null && this.old !== undefined) {
        if (this.old.ratingtitle) {
            const uuids = Object.keys(this.old.ratingtitle[this.uuid]);

            for(let i = 0; i < uuids.length; i++) {
                const uuid = uuids[i];
                this.ratings.push(
                {
                    uuid: uuid,
                    title: (this.old.ratingtitle[this.uuid][uuid] || ''),
                    description: (this.old.ratingdescription[this.uuid][uuid] || ''),
                    points: (this.old.ratingpoints[this.uuid][uuid] || 0),
                }
                );
                console.log(this.ratings);
            }

            console.log(uuids);
        }
    }
  },
};
</script>
