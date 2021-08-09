<template>
    <section v-if="isLoadedStudents && isLoadedRubricData">
        <p>
            <span v-if="students.length === 0">You have no students to grade.</span>
            <span v-else-if="students.length === 1">You have {{ students.length }} student to grade.</span>
            <span v-else>You have {{ students.length }} students to grade.</span>
        </p>
        <div class="alert-fixed alert alert-light" role="alert" v-if="message">
            {{ message }}
        </div>
        <div v-if="students.length > 0">
        <student-grading-student-article
            v-for="student in students"
            :key="student.id"
            :student="student"
            :rubrics="rubrics"
            @message="messageEvt"
        >
        </student-grading-student-article>
        </div>
        <span v-if="false">
        <pre>{{ students }}</pre>
        <pre>{{ rubrics }}</pre>
        </span>
    </section>
</template>

<script>
import StudentGradingStudentArticle from './StudentGradingStudentArticle.vue';
export default {
    name: 'StudentGrading',
    components: {
        StudentGradingStudentArticle,
    },
    data() {
        return {
            isLoadedStudents: false,
            isLoadedRubricData: false,
            students: [],
            rubrics: [],
            message: '',
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
    methods: {
        messageEvt(msg) {
            this.message = msg;
            setTimeout(() => this.message = '', 1000);
        }
    },
}
</script>
