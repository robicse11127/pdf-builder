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
                            <th width="35%">Action</th>
                        </tr>
                    </thead>
                    <tbody v-for="(form, index) in forms" :key="index">
                        <tr>
                            <td>{{index+1}}</td>
                            <td>{{form.form_name}}</td>
                            <td>
                                <router-link :to="'/admin/forms/edit/'+form.id">Edit</router-link>
                                <a href="#" @click.prevent="deleteForm(form.id)">Delete</a>
                                <a href="#" @click.prevent="showModal(index, form.id, form.form_name)">Preview</a>
                                <a :href="'/admin/generate_pdf/'+form.id">Download</a>
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
                            <img :src="'/storage/images/'+item.value" />
                        </div>
                        <div class="image" v-if="item.type == 'text-field'">
                            <p class="text-field">{{item.value}}</p>
                        </div>
                        <div class="image" v-if="item.type == 'textarea-field'">
                            <p class="textarea-field">{{item.value}}</p>
                        </div>
                        <div class="image" v-if="item.type == 'label-field'">
                            <p class="label-field"><strong>{{item.value}}</strong></p>
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
                this.previewForm.name = event.params.form_name;
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