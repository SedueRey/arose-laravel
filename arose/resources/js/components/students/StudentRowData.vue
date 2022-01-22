<template>
    <tr
        :class="`table-${status}`"
        v-if="student"
    >
        <td class="text-center">
            <input type="checkbox" id="" aria-label=""
                :checked="(status === 'light')? 'checked' : ''"
                @change="updateStudent"
            />
        </td>
        <td>
            <input class="form-control form-control-sm" type="text" v-model="surname" @change="updateStudent" />
        </td>
        <td>
            <input class="form-control form-control-sm" type="text" v-model="name" @change="updateStudent" />
        </td>
        <td class="text-right">
            <input style="width: 100%" class="form-control form-control-sm" type="number" step="1" v-model="age" @change="updateStudent" />
        </td>
        <td class="text-center">
            <input style="width: 100%" class="form-control form-control-sm" type="text" v-model="sclass" @change="updateStudent" />
        </td>
        <td>
            <select style="width: 100%" class="form-control form-control-sm" @change="updateLevel" v-model="level">
                <option value="A1" :selected="level === 'A1' ? 'selected' : ''">A1</option>
                <option value="A2" :selected="level === 'A2' ? 'selected' : ''">A2</option>
                <option value="B1" :selected="level === 'B1' ? 'selected' : ''">B1</option>
                <option value="B2" :selected="level === 'B2' ? 'selected' : ''">B2</option>
                <option value="C1" :selected="level === 'C1' ? 'selected' : ''">C1</option>
                <option value="C2" :selected="level === 'C2' ? 'selected' : ''">C2</option>
                <option
                    value="Unknown"
                    :selected="level === 'Unknown' ? 'selected' : ''"
                >Unknown</option>
            </select>
        </td>
        <td>
            <input style="width: 100%" class="form-control form-control-sm" type="text" v-model="group" @change="updateStudent" />
        </td>
    </tr>
</template>
<script>
export default {
    name: 'StudentRowData',
    props: {
        uuid: { type: Number, required: true },
        row: { type: Object, required: false, default: {} },
    },
    data() {
        return {
            student: null,
            check: false,
            surname: '',
            name: '',
            age: '',
            sclass: '',
            group: '',
            status: '',
            level: '',
        }
    },
    mounted() {
        this.updatedProp();
    },
    methods: {
        updatedProp() {
            this.student = {...this.row};
            this.status = this.row.status;
            this.surname = this.row.surname;
            this.name = this.row.name;
            this.age = this.row.age;
            this.sclass = this.row.class;
            this.level = this.row.level;
            this.group = this.row.group;
        },
        updateLevel (newData) {
            this.level = newData.srcElement.value;
            this.updateStudent()
        },
        updateStudent () {
            const {
                status,
                surname,
                name,
                age,
                sclass,
                level,
                group,
                uuid
            } = this;
            this.$emit('updateStudent', {
                status, surname, name, age,
                level, group, uuid,
                class: sclass
            })
        }
    },
    watch: {
        row: function(newVal, oldVal) { // watch it
            this.updatedProp();
        }
    }
}
</script>
