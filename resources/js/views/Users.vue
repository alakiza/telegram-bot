<template>
    <b-container fluid>
        <b-row>
            <b-col>
                <b-button variant="outline-primary" id="show-modal" @click="ShowAddDialog">➕</b-button>
            </b-col>

            <add-dialog v-if="showModal" 
                v-bind:old_data="old_data"
                @close="CloseAddDialog">
            </add-dialog>
        </b-row>
        <b-table :items="users_table.items" :fields="users_table.fields">
            <template #table-colgroup="scope">
                <col
                v-for="field in scope.fields"
                :key="field.key"
                :style="{ width: field.key === 'delete' ? '20%' : '40%' }"
                >
            </template>

            <template #cell(actions)="row">
                <div class="close-button-wrapper">
                    <b-button class="close" @click="UpdateItem(row)">🖉</b-button>
                    <b-button-close @click="DeleteItem(row)"></b-button-close>
                </div>
            </template>
        </b-table>

    </b-container>
</template>

<script>
import AddUser from './AddUser.vue'
import * as user_helper from '../helpers/users.js'

export default {
    components: {
        'add-dialog': AddUser
    },
    data: function() {
        return { 
            showModal: false,
            old_data: null,
            users_table: {
                fields: [{
                            'key': 'email',
                            'label': 'email'
                        }, 
                        {
                            'key': 'name',
                            'label': 'ФИО'
                        }, 
                        {   
                            'key': 'actions',
                            'label': 'Действия'
                        }],
                items: []

            },
        }
    },
    methods: {
        CloseAddDialog: function () {
            this.GetUsers()

            this.showModal = false
        },
        ShowAddDialog: function () {
            this.old_data = null

            this.showModal = true
        },
        GetUsers: function() {
            user_helper.getUsers({
                then: (response) => {
                    this.users_table.items = response.data
                }
            })
        },
        DeleteItem: function(row) {
            user_helper.deleteUser({
                data: {
                    id: row.item.id
                },
                then: () => {
                    this.GetUsers()
                }
            })
        },
        UpdateItem: function(row) {
            this.old_data = row.item

            this.showModal = true
        },
    },
    mounted() {
        this.GetUsers()
    }
}
</script>