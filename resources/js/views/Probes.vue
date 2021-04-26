<template>
    <b-container fluid>
        <b-row>
            <b-col>
                <b-button variant="outline-primary" id="show-modal" @click="ShowAddDialog">➕</b-button>
            </b-col>

            <add-probe v-if="showModal" 
                v-bind:base_probes="base_probes" 
                v-bind:base_probes_params="base_probes_params" 
                v-bind:old_data="old_data"
                @close="CloseAddDialog">
            </add-probe>
        </b-row>

        <b-table :items="probes" :fields="probes_table.fields">
            <template #table-colgroup="scope">
                <col
                v-for="field in scope.fields"
                :key="field.key"
                :style="{ width: field.key === 'delete' ? '20%' : '40%' }"
                >
            </template>

            <template #head(delete)="row">
                {{row.field["label"]}}
            </template>
            
            <template #cell(name)="row">
                {{row.item.name}}
            </template>

            <template #cell(base_probe)="row">
                {{base_probes_list[row.item.base_probes_id]}}
                <!-- {{base_probes[row.item.base_probes_id].name}} -->
            </template>

            <template #cell(parameters)="row">
                <p v-for="(value, name) in row.item.parameters" :key="name"> {{name}}:{{value}} </p>
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
import * as probe_helper from '../helpers/probes.js'
import * as parameters_helper from '../helpers/parameters.js'

import AddProbeDialog from './AddProbe.vue'

export default {
    components: {
        'add-probe': AddProbeDialog
    },
    data: function() {
        return {
            probes: [],
            base_probes_params: [],
            base_probes_list: {},
            base_probes: [],
            probes_table: {
                fields: [{
                            'key': 'name',
                            'label': 'Название'
                        }, 
                        {
                            'key': 'base_probe',
                            'label': 'Тип проверки'
                        }, 
                        {
                            'key': 'parameters',
                            'label': 'Параметры'
                        }, 
                        {   
                            'key': 'actions',
                            'label': 'Действия'
                        }]
            },
            old_data: null,
            showModal: false
        }
    },
    methods: {
        GetBaseProbes: function() {
            probe_helper.getBaseProbes({
                then: response => {
                    this.base_probes = response.data

                    this.base_probes_list = {}
                    this.base_probes.forEach((item) => {
                        this.base_probes_list[item.id] = item.name
                    });
                }
            })
        },
        GetAvailableParameters: function() {
            parameters_helper.getAvailableParameters({
                then: response => {
                    this.base_probes_params = response.data
                }
            })
        },
        AddProbe: function(new_probe) {
            probe_helper.addProbe({
                data: new_probe,
                then: () => {
                    this.GetProbes()
                }
            })
        },
        DeleteItem: function(row) {
            probe_helper.deleteProbe({
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
        GetProbes: function() {
            probe_helper.getProbes({
                then: response => {
                    this.probes = response.data
                }
            })
        },
        ShowAddDialog: function(event) {
            this.showModal = true
        },
        CloseAddDialog: function(event) {
            this.GetProbes()

            this.showModal = false
        }
    },
    mounted() {
        this.GetBaseProbes()
        this.GetAvailableParameters()
        this.GetProbes()
    }
}
</script>
<style>
@import url('../../css/SingleTarget.css');
</style>