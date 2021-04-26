<template>
    <custom-add-modal  @close="close" @addButtonClick="OnAddButtonClick">
        <template v-slot:header>
            <p>Добавление метрики</p>
        </template>

        <template v-slot:body>
            <b-container fluid>
                <b-row>
                    <b-col cols=8>
                        <b-form-input v-model="new_data.name" placeholder="Введите название метрики"></b-form-input>
                    </b-col>
                    <b-col cols=4>
                        <b-form-select v-model="new_data.base_probes_id" :options="base_probe_list">
                            <template #first>
                                <b-form-select-option :value="null" disabled>-- Выберите тип метрики --</b-form-select-option>
                            </template>
                        </b-form-select>
                    </b-col>
                </b-row>
                <b-row v-if="new_data.base_probes_id != null" cols="2">
                    <b-col v-for="(type, name, index) in base_probe_params_dict[new_data.base_probes_id]" :key="index">
                        <b-form-input v-model="new_data.parameters[name]" v-bind:placeholder="name"></b-form-input>
                    </b-col>
                </b-row>
            </b-container>
        </template>
    </custom-add-modal>   
</template>
<script>
import customAddModal from './CustomAddModalWindow'
import * as probe_helper from '../helpers/probes.js'

export default {
    components: {
        'custom-add-modal': customAddModal,
    },
    data: function() {
        return {
            base_probe_params_dict: {},
            base_probe_list: [],
            new_data: {
                name: null,
                base_probes_id: null,
                parameters: {}
            }
        }
    },
    props: {
        base_probes: Array,
        base_probes_params: Array,
        old_data: Object,
    },
    methods: {
        OnAddButtonClick: function(event) {
            if(this.old_data !== null) {
                probe_helper.updateProbe({
                    data: {
                        id: this.old_data.id,
                        new: this.new_data,
                    },
                    then: () => {
                        this.$emit('close')
                    }
                })
            } else {
                probe_helper.addProbe({
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

        this.base_probes.forEach((item) => {
            this.base_probe_list.push({
                value: item.id,
                text: item.name
            })
        })

        this.base_probes_params.forEach((item) => {
            this.base_probe_params_dict[item.base_probes_id] = item.parameters
        })

    },
}
</script>
<style>
@import url('../../css/ModalWindow.css');
</style>
