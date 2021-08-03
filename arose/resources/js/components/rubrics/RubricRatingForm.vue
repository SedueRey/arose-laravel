<template>
  <div class="rating">
    <div class="form-group row">
        <aside class="col-sm-12">
        <slot></slot>
        </aside>
    </div>
    <div class="form-group row">
      <label
        :for="`ratingtitle[${uuid}][${rating.uuid}]`"
        class="col-sm-2 col-form-label"
        >Rating title</label>
      <div class="col-sm-6">
        <input
          required
          type="text"
          class="form-control"
          :id="`ratingtitle[${uuid}][${rating.uuid}]`"
          :name="`ratingtitle[${uuid}][${rating.uuid}]`"
          v-model="usingRating.title"
        />
      </div>
      <label :for="`ratingpoints[${rating.uuid}]`" class="col-sm-2 col-form-label text-sm-right">Rating points</label>
      <div class="col-sm-2">
        <input
          type="number"
          required
          class="form-control"
          :id="`ratingpoints[${uuid}][${rating.uuid}]`"
          :name="`ratingpoints[${uuid}][${rating.uuid}]`"
          v-model="usingRating.points"
          min="0"
          step="0.5"
          @change="passPoints"
        />
      </div>
    </div>
    <div class="form-group row">
      <label :for="`ratingdescription[${uuid}][${rating.uuid}]`" class="col-sm-2 col-form-label">
        Rating description
      </label>
      <div class="col-sm-10">
        <textarea
          rows="2"
          required
          class="form-control"
          :id="`ratingdescription[${uuid}][${rating.uuid}]`"
          :name="`ratingdescription[${uuid}][${rating.uuid}]`"
          v-model="usingRating.description"
        ></textarea>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "RubricRatingForm",
  props: {
    rating: { type: Object, required: true },
    uuid: { type: String, required: true },
  },
  data() {
      return {
          usingRating: {}
      }
  },
  mounted() {
    this.usingRating = {...this.rating};
  },
  methods: {
      passPoints(e) {
          const points = parseFloat(e.target.value.replace(',', '.'));
          this.$emit('points', {
              uuid: this.rating.uuid,
              points: points
          });
      }
  },
};
</script>
