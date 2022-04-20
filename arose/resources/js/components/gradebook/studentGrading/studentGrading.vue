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
        <aside class="filter alert alert-info">
            <div class="row">
                <div class="col-md-12">
                    Search:<br />
                    <input class="form-control" type="text" v-model="search" placeholder="Search..." />
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <br />Sort by :
                    <select v-model="order" class="form-control">
                        <option value="surname">Family name</option>
                        <option value="name">Given Name</option>
                        <option value="level">English level</option>
                        <option value="group">Group</option>
                    </select>
                </div>
                <div class="col-md-8">
                    <strong>
                        Only show: <br />
                    </strong>
                    <div class="row">
                        <div class="col-md-4" v-if="allClass.length > 0">
                            Class:
                            <select v-model="classActive" class="form-control">
                                <option value="">Show all</option>
                                <option
                                    v-for="value in allClass" :key="value"
                                    :value="value"
                                >
                                    Show only class "{{ value }}"
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4" v-if="allGroup.length > 0">
                            Group:
                            <select v-model="group" class="form-control">
                                <option value="">Show all</option>
                                <option
                                    v-for="value in allGroup" :key="value"
                                    :value="value"
                                >
                                    Show only group "{{ value }}"
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4" v-if="allLevel.length > 0">
                            English Level:
                            <select v-model="level" class="form-control">
                                <option value="">Show all</option>
                                <option
                                    v-for="value in allLevel" :key="value"
                                    :value="value"
                                >
                                    Show only level "{{ value }}"
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        <hr />
        <student-grading-student-article
            v-show="contains(student.id)"
            v-for="student in sortedStudents"
            :key="student.id"
            :student="student"
            :rubrics="rubrics"
            @message="messageEvt"
        >
        </student-grading-student-article>
        </div>
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
            search: '',
            order: 'surname',
            classActive: '',
            group: '',
            level: '',
            allClass: [],
            allGroup: [],
            allLevel: [],
        }
    },
    computed: {
        filteredStudentsId() {
            let filter = [...this.students].filter(
                el => {
                    const hasApellidos = el.surname.normalize('NFD')
                        .replace(/\p{Diacritic}/gu, '')
                        .toLocaleLowerCase().indexOf(this.search) > -1;
                    const hasNombre = el.name.normalize('NFD')
                        .replace(/\p{Diacritic}/gu, '')
                        .toLocaleLowerCase().indexOf(this.search) > -1;
                    return (this.search === '') || hasApellidos || hasNombre;
                }
            );
            if (this.group !== '') {
                filter = filter.filter(
                    el => el.group === this.group
                );
            }
            if (this.level !== '') {
                filter = filter.filter(
                    el => el.level === this.level
                );
            }
            if (this.classActive !== '') {
                filter = filter.filter(
                    el => el.class === this.classActive
                );
            }
            const usersId = filter.map(el => el.id)
            return usersId;
        },
        sortedStudents() {
            return this.students.sort(
                (a,b) => a[this.order].localeCompare(b[this.order])
            );
        },
    },
    mounted() {
        axios.get('/gradebook/api/mystudents/')
          .then(response => {
              this.isLoadedStudents = true;
              this.students = [];
              this.students = response.data;
              this.allClass = [...new Set(this.students.map( el => el.class).filter(el => el !== null))]
              this.allGroup = [...new Set(this.students.map( el => el.group))]
              this.allLevel = [...new Set(this.students.map( el => el.level))]
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
        },
        contains(userId) {
            return this.filteredStudentsId.includes(userId);
        }
    },
}
</script>
