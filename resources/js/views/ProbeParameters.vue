<template>
    <b-container fluid>
        <b-row>
            <b-col>
                <!-- <b-button id="show-modal" @click="AddProbeDialogShow">Добавить</b-button> -->
                {{}}
            </b-col>

        </b-row>

        <!-- <b-table :items="probes" :fields="probes_table.fields">
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
                {{base_probes[row.item.base_probe_id]}}
            </template>

            <template #cell(delete)="row">
                <div class="close-button-wrapper">
                    <b-button-close @click="DeleteProbe(row)"></b-button-close>
                </div>
            </template>
        </b-table> -->

    </b-container>
</template>

<script>
import axios from 'axios'

export default {
    data: function() {
        return {
            // probes: [],
            // base_probes: [],
            // probes_table: {
            //     fields: [{
            //                 'key': 'name',
            //                 'label': 'Название'
            //             }, 
            //             {
            //                 'key': 'base_probe',
            //                 'label': 'Тип проверки'
            //             }, 
            //             {
            //                 'key': 'parameters',
            //                 'label': 'Параметры'
            //             }, 
            //             {   
            //                 'key': 'delete',
            //                 'label': 'Удалить'
            //             }]
            // },
            // showModal: false
        }
    },
    methods: {
        AddProbeParameters: function() {
            axios({
                method: 'post',
                url: "http://192.168.6.149/api/addavailableprobeparameter",
                data: {
                    base_probes_id: 1,
                    parameters: {
                        size: 'integer',
                        count: 'integer'
                    }
                }
            })
        }
    },
    mounted() {
        console.log('test')
        this.AddProbeParameters()
    }
}
</script>
<style>
@import url('../../css/SingleTarget.css');
</style>