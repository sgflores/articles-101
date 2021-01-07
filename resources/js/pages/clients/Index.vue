<template>
    <div>
        <ClientForm />
        <hr />
        <ClientTable />
    </div>
</template>

<script>
import ClientForm from '../../components/clients/Form';
import ClientTable from '../../components/clients/Table';
export default {
    components: {
        ClientForm,
        ClientTable
    }
}
</script>