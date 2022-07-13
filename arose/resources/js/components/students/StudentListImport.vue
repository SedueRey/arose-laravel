<template>
<div class="table-responsive">
    <student-send-data
        :studentsprop="studentsOrdered"
        :start="uploading"
        v-if="uploading"
        @endSaving="endSaving"
    >
    </student-send-data>
    <div class="alert alert-danger" role="alert" v-if="studentWithProblems > 1">
        There are <strong>{{ studentWithProblems }}</strong> of {{ students.length }} students with data that needs to be checked.
    </div>
    <div class="alert alert-danger" role="alert" v-if="studentWithProblems === 1">
        There is {{ studentWithProblems }} student of {{ students.length }} students with data that needs to be checked.
    </div>
    <p v-if="studentWithProblems > 0">
        <strong>
            Check the student row if you want to save her / him. Same, uncheck whoever you want to not be saved.
        </strong>
    </p>
    <p>
        Please, check all the data and, if it's all right, click on save button. You can change all data later, of course, once
        everything is saved.
    </p>
    <table class="table table-bordered table-hover table-sm">
        <thead>
            <tr class="text-center">
                <th></th>
                <th>Family Name</th>
                <th>Given Name</th>
                <th>Age</th>
                <th>Class</th>
                <th>Level</th>
                <th>Group</th>
            </tr>
        </thead>
        <tbody>
            <student-row-data
                v-for="(student, index) in studentsOrdered" :key="index"
                :row="student"
                :uuid="index"
                @updateStudent="updateStudent"
            ></student-row-data>
        </tbody>
    </table>
    <button
        class="btn btn-primary"
        @click="upload"
        :disabled="uploading ? true : false"
    >
        Upload all data
    </button>
</div>
</template>
<script>
import StudentRowData from './StudentRowData.vue';
import StudentSendData from './StudentSendData.vue';
export default {
    name: 'StudentListImport',
    props: {
        studentsprop: { type: Object, required: false, default: () => [] },
    },
    components: {
        StudentRowData,
        StudentSendData,
    },
    computed: {
        studentsOrdered () {
            return this.students.sort((a,b) => {
                if (a.status !== 'light') return -1
                if (b.status !== 'light') return 1
                return 0
            });
        },
        studentWithProblems () {
            return this.students.filter( el => el.status !== 'light').length;
        },
    },
    data() {
        return {
            students: [],
            uploading: false,
        }
    },
    mounted() {
        const copy = JSON.parse(JSON.stringify(this.studentsprop));
        this.students = Object.keys(copy).map(key => {
            return copy[key];
        });
    },
    methods: {
        upload() {
            this.uploading = true;
        },
        endSaving() {
            this.uploading = false;
        },
        updateStudent(newData) {
            const stu = this.students[newData.uuid];
            stu.status = newData.status;
            stu.surname = newData.surname;
            stu.name = newData.name;
            stu.age = newData.age;
            stu.class = newData.class;
            stu.level = newData.level;
            stu.group = newData.group;

            if (
                ['A1','A2','B1','B2','C1','C2', 'Unknown'].includes(stu.level)
                && Number.isInteger(parseInt(stu.age, 10))
            ) {
                stu.status = 'light';
            }
        }
    }
}
</script>
