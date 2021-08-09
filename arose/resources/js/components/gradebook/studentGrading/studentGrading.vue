<template>
    <section v-if="isLoadedStudents && isLoadedRubricData">
        You have {{ students.length }} students.
        <pre>{{ students }}</pre>
        <pre>{{ rubrics }}</pre>
    </section>
</template>

<script>
export default {
    name: 'StudentGrading',
    data() {
        return {
            isLoadedStudents: false,
            isLoadedRubricData: false,
            students: [],
            rubrics: [],
        }
    },
    mounted() {
        axios.get('/gradebook/api/mystudents/')
          .then(response => {
              this.isLoadedStudents = true;
              this.students = [];
              this.students = response.data;
          });
        axios.get('/gradebook/api/myusedrubrics')
          .then(response => {
              this.isLoadedRubricData = true;
              this.rubrics = response.data;
          });
    },
}
</script>
