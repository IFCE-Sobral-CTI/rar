import React from "react";
import { Head, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Panel from "@/Components/Dashboard/Panel";
import Form from "./Components/Form";

function Create() {
    const { data, setData, post, processing, errors } = useForm({
        description: '',
        status: '',
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('types.store'), {data});
    };

    return (
        <>
            <Head title="Novo tipo de requerimento" />
            <AuthenticatedLayout
                titleChildren={'Cadastro de novo tipo de requerimento'}
                breadcrumbs={[
                    { label: 'Tipos de requerimentos', url: route('types.index') },
                    { label: 'Novo', url: route('types.create') }
                ]}
            >
                <Panel className={'flex-1'}>
                    <Form data={data} errors={errors} processing={processing} onHandleChange={onHandleChange} handleSubmit={handleSubmit} />
                </Panel>
            </AuthenticatedLayout>
        </>
    )
}

export default Create;

