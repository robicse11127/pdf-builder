<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Create New From</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <draggable
                                v-model="fields"
                                class="dragArea list-group"
                                :clone="clone"
                                :group="{ name: 'fields', pull: 'clone', put: false }"
                                >
                                    <div class="list-group-item aside-menu" v-for="(element, index) in fields" :key="index">
                                        {{ element.label }}
                                    </div>
                                </draggable>
                            </div>
                            <div class="col-md-10"> 
                                <h4>
                                    <span class="form-name" @click="enableFormNameEdit" v-if="!editFormName">{{formName}}</span>
                                    <input type="text" ref="formName" class="form-control form-name" v-model="formName" v-if="editFormName" v-on:blur="disableFormNameEdit" placeholder="Enter Form Name">
                                </h4>
                                <form v-on:submit.prevent>
                                    <input type="hidden" name="_method" value="post">
                                    <draggable
                                        class="form-drag-area list-group"
                                        v-model="formFields"
                                        handle=".handle"
                                        :group="{name: 'fields'}"
                                    >
                                        <div
                                        class="list-group-item" v-for="(element, index) in formFields" :key="index">
                                            <div v-if="element.type === 'label-field'">
                                                <div class="row">
                                                    <div class="col-md-10" :data-index="index"> 
                                                        <span class="form-label" @click="editLabel(index)">
                                                            <span v-if="formFields[index]['value']">{{formFields[index]['value']}}</span>
                                                            <span v-else>{{element.label}}</span>
                                                            <span class="edit-lavel" @click="editLabel(index)"><small>Edit</small></span>
                                                        </span>
                                                        <input 
                                                            v-show="editLabelIndex===index" 
                                                            type="text" :name="'label_field_'+ index" 
                                                            class="form-control" 
                                                            v-model="formFields[index]['value']" 
                                                            v-on:blur="hideLabelInput"
                                                            placeholder="Add label"
                                                        >
                                                    </div>
                                                    <div class="col-md-2 text-right">
                                                        <button class="btn btn-secondary handle">
                                                            <svg id="i-menu" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="12" height="12" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                <path d="M4 8 L28 8 M4 16 L28 16 M4 24 L28 24" />
                                                            </svg>
                                                        </button>
                                                        <button class="btn btn-danger" @click.prevent="removeAt(index)">
                                                            <svg id="i-close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="12" height="12" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                <path d="M2 30 L30 2 M30 30 L2 2" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-if="element.type === 'text-field'">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <input type="text" :name="'text_field_'+ index" class="form-control" v-model="element.value" :placeholder="element.label">
                                                    </div>
                                                    <div class="col-md-2 text-right">
                                                        <button class="btn btn-secondary handle">
                                                            <svg id="i-menu" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="12" height="12" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                <path d="M4 8 L28 8 M4 16 L28 16 M4 24 L28 24" />
                                                            </svg>
                                                        </button>
                                                        <button class="btn btn-danger" @click.prevent="removeAt(index)">
                                                            <svg id="i-close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="12" height="12" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                <path d="M2 30 L30 2 M30 30 L2 2" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-if="element.type === 'textarea-field'">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <textarea :name="'textarea_field_'+index" class="form-control" rows="4" v-model="element.value" :placeholder="element.label"></textarea>
                                                    </div>
                                                    <div class="col-md-2 text-right">
                                                        <button class="btn btn-secondary handle">
                                                            <svg id="i-menu" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="12" height="12" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                <path d="M4 8 L28 8 M4 16 L28 16 M4 24 L28 24" />
                                                            </svg>
                                                        </button>
                                                        <button class="btn btn-danger" @click.prevent="removeAt(index)">
                                                            <svg id="i-close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="12" height="12" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                <path d="M2 30 L30 2 M30 30 L2 2" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-if="element.type === 'checkbox-field'">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="custom-control custom-checkbox">
                                                            <input v-model="element.value" type="checkbox" :id="'checkbox_id_'+index" class="custom-control-input" :name="'checkbox_field_'+ index">
                                                            <label class="custom-control-label" :for="'checkbox_id_'+index">{{element.label}}</label>
                                                            <span class="edit-lavel" @click="editLabel(index)"><small>Edit</small></span>
                                                            <input 
                                                            v-show="editLabelIndex===index" 
                                                            type="text" :name="'checkbox_label_field_'+ index" 
                                                            class="form-control" 
                                                            v-model="formFields[index]['label']" 
                                                            v-on:blur="hideLabelInput"
                                                            placeholder="Edit label"
                                                        >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 text-right">
                                                        <button class="btn btn-secondary handle">
                                                            <svg id="i-menu" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="12" height="12" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                <path d="M4 8 L28 8 M4 16 L28 16 M4 24 L28 24" />
                                                            </svg>
                                                        </button>
                                                        <button class="btn btn-danger" @click.prevent="removeAt(index)">
                                                            <svg id="i-close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="12" height="12" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                <path d="M2 30 L30 2 M30 30 L2 2" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-if="element.type === 'radio-field'">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="custom-control custom-radio">
                                                            <input v-model="element.value" type="radio" :id="'radio_field_'+ index" :name="'radio_field_'+ index" class="custom-control-input">
                                                            <label class="custom-control-label" :for="'radio_field_'+ index">{{element.label}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 text-right">
                                                        <button class="btn btn-secondary handle">
                                                            <svg id="i-menu" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="12" height="12" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                <path d="M4 8 L28 8 M4 16 L28 16 M4 24 L28 24" />
                                                            </svg>
                                                        </button>
                                                        <button class="btn btn-danger" @click.prevent="removeAt(index)">
                                                            <svg id="i-close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="12" height="12" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                <path d="M2 30 L30 2 M30 30 L2 2" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-if="element.type === 'upload-field'">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="image-preview">
                                                            <img :src="image[index]" width="150" />
                                                        </div>
                                                        <div class="upload-btn-wrapper">
                                                            <button class="btn btn-secondary btn-upload-file">Upload a file</button>
                                                            <input type="file" v-on:change="onImageChange" @click="getIndex(index)" :name="'upload_field_'+ index" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 text-right">
                                                        <button class="btn btn-secondary handle">
                                                            <svg id="i-menu" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="12" height="12" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                <path d="M4 8 L28 8 M4 16 L28 16 M4 24 L28 24" />
                                                            </svg>
                                                        </button>
                                                        <button class="btn btn-danger" @click.prevent="removeAt(index)">
                                                            <svg id="i-close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="12" height="12" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                <path d="M2 30 L30 2 M30 30 L2 2" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </draggable>
                                    <button type="submit" name="submit" @click.prevent="submitFrom" id="submit" class="btn btn-success mt-4" v-if="formFields != ''">Save Form</button>
                                    <span v-if="success != ''" class="text-success js-form-notice">{{success}}</span>
                                    <span v-if="error != ''" class="text-danger js-form-notice">{{error}}</span>
                                    <span v-if="notice != ''" class="text-success js-form-notice">{{notice}}</span>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script>
    import draggable from "vuedraggable";

    export default {
        components: {
            draggable,
        },
        data() {
            return {
                formName: 'Form Name',
                editFormName: false,
                editLabelIndex: -1,
                fields: [
                    {label: 'Label', type: 'label-field', value: ''},
                    {label: 'Text Field', type: 'text-field'},
                    {label: 'Textarea Field', type: 'textarea-field'},
                    // {label: 'Radio', type: 'radio-field'},
                    {label: 'Checkbox', type: 'checkbox-field'},
                    {label: 'Upload', type: 'upload-field'}, 
                ],
                formFields: [],
                success: '',
                error: '',
                notice: '',
                image: [],
                currentIndex: 0
            };
        },
        methods: {
            clone(item) {
                return JSON.parse(JSON.stringify(item))
            },
            getIndex(index) {
                this.currentIndex = index;
            },
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0], this.currentIndex);
            },
            createImage(file, index) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.formFields[index]['value'] = e.target.result;
                    vm.formFields[index]['changed'] = true;
                    vm.$set(vm.image, index, e.target.result);
                };
                reader.readAsDataURL(file);
            },
            submitFrom(){
                this.notice = 'Saving...';
                var self = this;
                axios({
                    method: 'post',
                    url: '/admin/forms/',
                    data: {
                        form_name: this.formName,
                        fields: this.formFields
                    },
                })
                .then((res) => {
                    this.success = 'Form successfully saved!';
                    this.error = '';
                    this.notice = '';
                    self.$router.push('/admin/forms');
                })
                .catch((error) => {
                    this.error = 'Something went wrong!!!';
                    this.notice = '';
                })
            },
            removeAt(index) {
                this.formFields.splice(index, 1);
            },
            editLabel(index) {
                this.editLabelIndex = index;
            },
            hideLabelInput() {
                this.editLabelIndex = -1; 
            },
            enableFormNameEdit() {
                this.editFormName = true;
            },
            disableFormNameEdit() {
                this.editFormName = false;
            },
        }
    }
</script>

<style>
.handle:hover,
.aside-menu:hover {
    cursor: move;
}
.form-label:hover,
.edit-lavel {
    cursor: pointer;
}
.btn-upload-file {
    min-width: 150px;
    margin-top: 10px;
}
.upload-btn-wrapper {
    position: relative;
    overflow: hidden;
    display: inline-block;
}
.upload-btn-wrapper input[type=file] {
    font-size: 100px;
    position: absolute;
    left: 0;
    top: 0;
    opacity: 0;
}
.form-drag-area {
    background: #fff;
    display: block;
    min-height: 280px;
    padding: 20px;
    border: 2px dashed #f2f2f2;
}
.form-drag-area:hover {
    border: 2px dashed #38c172;
}
</style>
