<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>List of Forms</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="10%">No</th>
                            <th>Form Name</th>
                            <th width="25%">Action</th>
                        </tr>
                    </thead>
                    <tbody v-for="(form, index) in forms" :key="index">
                        <tr>
                            <td>{{index+1}}</td>
                            <td>{{form.form_name}}</td>
                            <td>
                                <router-link :to="'/admin/forms/edit/'+form.id" class="btn btn-primary">
                                <svg id="i-edit" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="16" height="16" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                    <path d="M30 7 L25 2 5 22 3 29 10 27 Z M21 6 L26 11 Z M5 22 L10 27 Z" />
                                </svg>
                                </router-link>
                                <a href="#" class="btn btn-danger" @click.prevent="deleteForm(form.id)">
                                    <svg id="i-trash" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="16" height="16" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                        <path d="M28 6 L6 6 8 30 24 30 26 6 4 6 M16 12 L16 24 M21 12 L20 24 M11 12 L12 24 M12 6 L13 2 19 2 20 6" />
                                    </svg>
                                </a>
                                <a href="#" class="btn btn-warning" @click.prevent="showModal(index, form.id, form.form_name)">
                                    <svg id="i-zoom-reset" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="16" height="16" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                        <circle cx="14" cy="14" r="12" />
                                        <path d="M23 23 L30 30" />
                                        <path d="M9 12 L9 9 12 9 M16 9 L19 9 19 12 M9 16 L9 19 12 19 M19 16 L19 19 16 19" />
                                    </svg>
                                </a>
                                <a :href="'/admin/generate_pdf/'+form.id" class="btn btn-success">
                                    <svg id="i-download" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="16" height="16" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                        <path d="M9 22 C0 23 1 12 9 13 6 2 23 2 22 10 32 7 32 23 23 22 M11 26 L16 30 21 26 M16 16 L16 30" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <modal name="form-preview" @before-open="beforeOpen" class="form-modal" 
                :width="'60%'" :height="'auto'" :adaptive="true" :scrollable="true" :pivotY=".2">
                    <div class="modal-header">
                        <h4>{{this.previewForm.name}}</h4>
                    </div>
                    <div class="modal-body" v-for="(item, index) in this.previewForm.data" :key="index">
                        <div class="image" v-if="item.type == 'upload-field'">
                            <img :src="'/storage/'+item.value" class="img-fluid"/>
                        </div>
                        <div class="text-field" v-if="item.type == 'text-field'">
                            <p class="text-field">{{item.value}}</p>
                        </div>
                        <div class="textarea-field" v-if="item.type == 'textarea-field'">
                            <p class="textarea-field">{{item.value}}</p>
                        </div>
                        <div class="label-field" v-if="item.type == 'label-field'">
                            <p class="label-field"><strong>{{item.value}}</strong></p>
                        </div>
                        <div class="checkbox-field" v-if="item.type == 'checkbox-field'">
                            <p class="checkbox-field" v-if="item.value == true"><strong>
                                <input type="checkbox" checked="checked"/> {{item.label}}
                            </strong></p>
                            <p class="checkbox-field" v-if="item.value == false"><strong>
                                <input type="checkbox"/> {{item.label}}
                            </strong></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a :href="'/admin/generate_pdf/'+this.previewForm.id" class="btn btn-primary">Save as PDF</a>
                    </div>
                </modal>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        
        data() {
            return {
                forms: '',
                previewForm: {
                    id: '',
                    name: '',
                    data: ''
                }
            }
        },
        created() {
            this.fetchForms();
        },
        methods: {
            fetchForms() {
                axios.get('/admin/forms')
                .then(res => {
                    this.forms = res.data
                })
            },
            showModal(index, formId, formName) {
                this.$modal.show('form-preview', {name: formName, data: this.forms[index].form_data, id: formId});
            },
            beforeOpen (event) {
                this.previewForm.id = event.params.id;
                this.previewForm.name = event.params.name;
                this.previewForm.data = event.params.data;
            },
            deleteForm(id) {
                axios({
                    method: 'delete',
                    url: '/admin/forms/'+id
                })
                .then((res) => {
                    this.fetchForms();
                })
            }
        }

    }
</script>

<style scoped>
.form-modal {
    padding: 30px;
}
</style>