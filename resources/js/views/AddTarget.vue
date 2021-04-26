<template>
    <custom-add-modal  @close="close" @addButtonClick="OnAddButtonClick">
        <template v-slot:header>
            <p>Добавление цели</p>
        </template>

        <template v-slot:body>
            <b-container fluid>
                <b-row>
                    <b-col cols=8>
                        <b-form-input v-model="new_data.name" placeholder="Введите название цели"></b-form-input>
                    </b-col>
                    <b-col cols=4>
                        <b-form-select v-model="new_data.probe_id" :options="probe_list">
                            <template #first>
                                <b-form-select-option :value="null" disabled>-- Выберите метрику --</b-form-select-option>
                            </template>
                        </b-form-select>
                    </b-col>
                </b-row>
                <b-row v-if="new_data.probe_id != null">
                    <b-col cols="12">
                        <b-form-input v-if="new_data.probe_id==1" v-model="new_data.resource_name" placeholder="Введите ip адрес или имя ресурса"></b-form-input>
                        <b-form-input v-if="new_data.probe_id==3" v-model="new_data.resource_name" placeholder="Введите номер speedtest сервера"></b-form-input>
                    </b-col>
                </b-row>
            </b-container>
        </template>
    </custom-add-modal>   
</template>

<script>
import customAddModal from './CustomAddModalWindow'
import * as target_helper from '../helpers/targets.js'

export default {
    components: {
        'custom-add-modal': customAddModal,
    },
    data: function() {
        return {
            probe_list: [],
            new_data: {
                name: null,
                resource_name: null,
                probe_id: null
            }
        }
    },
    props: {
        probes: Array,
        old_data: Object,
    },
    methods: {
        OnAddButtonClick: function(event) {
            if(this.old_data !== null) {
                target_helper.updateTarget({
                    data: {
                        id: this.old_data.id,
                        new: this.new_data,
                    },
                    then: () => {
                        this.$emit('close')
                    }
                })
            } else {
                target_helper.addTarget({
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

        this.probes.forEach((item) => {
            this.probe_list.push({
                value: item.id,
                text: item.name
            })
        })
    },
}
</script>
<style>
@import url('../../css/ModalWindow.css');
</style>
