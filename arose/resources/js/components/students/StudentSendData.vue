<template>
    <div class="studentSendData" v-if="studentsprop.length > 0 && start">
        <div class="studentSendData__inner">
            <h5>
                Uploaded {{ step }} of {{ max - studentWithProblems }}
            </h5>
            <h6 v-if="studentWithProblems > 0">
                skipping {{ studentWithProblems }} unchecked
            </h6>
            <progress id="file" :max="max" :value="step"> {{ step }}% </progress>
            <p>
                Uploading ... {{ name }} {{ surname }}
            </p>
            <button
                class="btn btn-sm btn-primary"
                v-if="finish"
                @click="goToStep3"
            >
                OK
            </button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import delay from '../../utils/delay';
export default {
    name: 'StudentSendData',
    props: {
        studentsprop: { type: Array, required: false, default: () => [] },
        start: { type:Boolean, required: false, default: false },
    },
    data() {
        return {
            callsDone: [],
            name: '',
            surname: '',
        }
    },
    computed: {
        step() {
            return this.callsDone.length;
        },
        max () {
            return this.studentsprop.length;
        },
        studentWithProblems () {
            return this.studentsprop.filter( el => el.status !== 'light').length;
        },
        finish () {
            return this.step >= (this.max - this.studentWithProblems);
        },
    },
    methods: {
        goToStep3() {
            window.location.href = '/students/importok'
        },
        async upload() {
            console.log(this.start);
            if(this.start) {
                console.log('start', this.max);
                const calls = this.callsDone;
                for (let index = 0; index < this.max; index++) {
                    const student = this.studentsprop[index];
                    console.log(student);
                    if (student.status === 'light') {
                        this.name = student.name;
                        this.surname = student.surname;
                        axios.post('/students/api/addimport', student)
                            .then(response => {
                                console.log(response);
                                calls.push('ok');
                            });
                        await delay(75);
                    }
                }
            }
        }
    },
    mounted() {
        // console.log(axios);
        this.upload();
    },
    watch: {
        start: function(newVal, oldVal) { // watch it
            if (newVal === true) {
                this.upload();
            }
        },
        studentsprop: function(newVal, oldVal) { // watch it
            if (this.start === true) {
                this.upload();
            }
        }
    }
}
</script>

<style lang="scss">
.studentSendData {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.4);
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    z-index: 15;

    &__inner {
        width: 50vw;
        height: 50vh;
        max-height: 50vh;
        overflow: auto;
        background-color: #FFF;
        box-shadow: 0 0 17px 0 rgb(0 0 0 / 15%);
        border-radius: 0.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        @media (max-width: 600px) {
            width: 70vw;
            height: 60vh;
            max-height: 60vh;
            overflow: auto;
        }
    }
}
</style>
