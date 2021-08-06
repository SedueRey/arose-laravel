<template>
    <section>
        <h1 class="h3">Config your gradebook with Rubrics. All levels the same</h1>
        <p>Divided by level: {{ dividedByLevel }}</p>
        <div class="row" v-if="false">
            <div class="col-md-12">
                <button title="Add to your Gradebook" class="btn btn-light">
                    <i class="fas fa-not-equal"></i> Use different rubrics for each English level
                </button>
            </div>
        </div>
        <div class="row" v-else>
            <div class="col-md-4 form-group">
            <label for="unify-all">Use level to copy for all:</label>
            <select id="unify-all" name="unify-all" class="form-control mb-2">
                <option value="C2">C2</option>
                <option value="C1">C1</option>
                <option value="B2">B2</option>
                <option value="B1">B1</option>
                <option value="A2">A2</option>
                <option value="A1">A1</option>
            </select>
            <button title="Add to your Gradebook" class="btn btn-light">
                <i class="fas fa-sync"></i> Unify rubrics for all levels
            </button>
            </div>
        </div>
        <div class="row mt-4">
            <nav class="col-md-12">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link  disabled" href="#">A1 <small>(0 students / disabled)</small></a></li>
                    <li class="nav-item"><a class="nav-link" href="#">A2 <small>(XX students)</small></a></li>
                    <li class="nav-item"><a class="nav-link" href="#">B1 <small>(XX students)</small></a></li>
                    <li class="nav-item"><a class="nav-link" href="#">B2 <small>(XX students)</small></a></li>
                    <li class="nav-item"><a class="nav-link" href="#">C1 <small>(XX students)</small></a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">C2 <small>(XX students)</small></a></li>
                </ul>
            </nav>
        </div>
        <p><strong>Pasar como prop el nivel</strong></p>
        <h2 class="h4 mt-4">My created Rubrics</h2>
        <div class="alert alert-info" role="alert" v-if="loadingMyRubrics">
            Loading my rubrics...
        </div>
        <div class="alert alert-info" role="alert" v-else-if="myrubrics.length === 0">
            There's no rubrics created by you. You can create one on your own.
        </div>
        <article class="vuerubric" :class="rubric.id % 2 === 1 ? 'is-active' : ''" v-for="rubric in myrubrics" :key="rubric.id">
            <p>
                <strong>{{rubric.title}}</strong>
                <nav class="float-right">
                    <button class="btn btn-light btn-sm"><i class="fas fa-search-plus"></i></button>
                    <button class="btn btn-light btn-sm"><i class="fas fa-search-minus"></i></button>
                    <button title="Add to your Gradebook" class="btn btn-light btn-sm">
                        <i class="fas fa-user-plus"></i> Add to gradebook
                    </button>
                    <button title="Add to your Gradebook" class="btn btn-light btn-sm">
                        <i class="fas fa-user-plus"></i> Remove from gradebook
                    </button>
                </nav>
            </p>
            <p>
                {{rubric.points}} max total points, used 'x' times for grading
            </p>
            <span v-if="true">
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
        <!--
        <pre>{{myrubrics}}</pre>
        -->

        <h2 h2 class="h4 mt-4">Rubrics shared by Arose project</h2>
        <div class="alert alert-info" role="alert" v-if="loadingSharedRubrics">
            Loading shared Arose project rubrics...
        </div>
    </section>
</template>

<script>
export default {
    name: 'ConfigGrading',
    data() {
        return {
            dividedByLevel: false,
            loadingUser: false,
            loadingMyRubrics: false,
            loadingSharedRubrics: false,
            myrubrics: [],
            sharedrubrics: [],
        }
    },
    mounted() {
        this.loadingMyRubrics = true;
        this.loadingSharedRubrics = true;
        this.loadingUser = true;
        axios.get('/gradebook/api/myself/')
          .then(response => {
              this.dividedByLevel = response.data.hasrubricsbygroups || false;
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
