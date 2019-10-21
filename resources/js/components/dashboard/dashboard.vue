<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>List of Forms</h4>
                    </div>
                    <div class="card-body">
                        <router-link to="/admin/forms">List of Forms</router-link>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Add New Forms</h4>
                    </div>
                    <div class="card-body">
                        <router-link to="/admin/forms/create">Create New Form</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        
    } 
</script>
