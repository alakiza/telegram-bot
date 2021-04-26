<template>
    <custom-add-modal  @close="close" @addButtonClick="OnAddButtonClick">
        <template v-slot:header>
            <p>Добавление пользователя</p>
        </template>

        <template v-slot:body>
            <b-container fluid>
                <b-row cols=1>
                    <b-col>
                        <b-form-input v-model="new_data.name" placeholder="ФИО нового пользователя"></b-form-input>
                    </b-col>
                    <b-col>
                        <b-form-input v-model="new_data.email" placeholder="email нового пользователя"></b-form-input>
                    </b-col>
                    <b-col>
                        <b-form-input type="password" v-model="new_data.password" placeholder="Пароль нового пользователя"></b-form-input>
                    </b-col>
                </b-row>
            </b-container>
        </template>
    </custom-add-modal>   
</template>

<script>
import customAddModal from './CustomAddModalWindow'
import * as auth_helper from '../helpers/auth.js'
import * as user_helper from '../helpers/users.js'

export default {
    components: {
        'custom-add-modal': customAddModal,
    },
    data: function() {
        return {
            probe_list: [],
            new_data: {
                name: null, 
                email: null,
                password: null
            },
        }
    },
    props: {
        old_data: Object,
    },
    methods: {
        OnAddButtonClick: function(event) {
            if(this.old_data !== null) {
                user_helper.updateUser({
                    data: {
                        id: this.old_data.id,
                        new: this.new_data
                    },
                    then: () => {
                        this.$emit('close')
                    }
                })
            } else {
                auth_helper.register({
                    data: this.new_data,
                    then: () => {
                        this.$emit('close')
                    }
                })
            }
        },
        close: function() {
            this.$emit('close')
        },
    },
    mounted() {
        if(this.old_data !== null) {
            this.new_data = this.old_data
        }
    }
}
</script>
<style>
@import url('../../css/ModalWindow.css');

</style>
