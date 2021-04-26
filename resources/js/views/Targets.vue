<template>
    <b-container fluid>
        <b-row>
            <b-col>
                <b-button variant="outline-primary" id="show-modal" @click="ShowAddDialog">➕</b-button>
            </b-col>

            <add-target v-if="showModal" 
                v-bind:probes="probes_list" 
                v-bind:old_data="old_data" 
                @close="CloseAddDialog">
            </add-target>
        </b-row>

        <b-table :items="target_table.items" :fields="target_table.fields">
            <template #table-colgroup="scope">
                <col
                v-for="field in scope.fields"
                :key="field.key"
                :style="{ width: field.key === 'delete' ? '20%' : '40%' }"
                >
            </template>
            
            <template #cell(probe)="row">
                {{probes[row.item.probe_id]}}
            </template>

            <template #head(delete)="row">
                {{row.field["label"]}}
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
import AddTargetDialog from './AddTarget.vue'
import * as probe_helper from '../helpers/probes.js'
import * as target_helper from '../helpers/targets.js'

export default {
    components: {
        'add-target': AddTargetDialog
    },
    data: function() {
        return {
            targets: [],
            probes: {},
            probes_list: [],
            target_table: {
                fields: [{
                            'key': 'name',
                            'label': 'Название'
                        }, 
                        {
                            'key': 'resource_name',
                            'label': 'Имя ресурса'
                        }, 
                        {
                            'key': 'probe',
                            'label': 'Тип проверки'
                        }, 
                        {   
                            'key': 'actions',
                            'label': 'Действия'
                        }],
                items: []
            },
            old_data: null,
            showModal: false
        }
    },
    methods: {
        GetTargets: function() {
            target_helper.getTargets({
                then: response => {
                    this.targets = response.data
                    this.target_table.items = this.targets
                }
            })
        },
        GetProbes: function() {
            probe_helper.getProbes({
                then: response => {
                    this.probes_list = response.data

                    this.probes = {}
                    this.probes_list.forEach((item)=> {
                        this.probes[item.id] = item.name
                    })
                }
            })
        },
        DeleteItem: function(row) {
            target_helper.deleteTarget({
                data: {
                    id: row.item.id
                },
                then: () => {
                    this.GetTargets()
                }
            })
        },
        UpdateItem: function(row) {
            this.old_data = row.item

            this.showModal = true
        },
        ShowAddDialog: function(event) {
            this.old_data = null

            this.showModal = true
        },
        CloseAddDialog: function(event) {
            this.GetTargets()

            this.showModal = false
        }
    },
    mounted() {
        this.GetTargets()
        this.GetProbes()
    }
}
</script>
<style>
@import url('../../css/SingleTarget.css');
</style>