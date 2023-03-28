import React from "react";
import { Head, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Panel from "@/Components/Dashboard/Panel";
import Form from "./Components/Form";

function Edit({ type }) {
    console.log(type);
    const { data, setData, put, processing, errors } = useForm({
        description: type.description,
        status: type.status? 1: 0,
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        put(route('types.update', type.id), {data});
    };

    return (
        <>
            <Head title="Editar tipo de requerimento" />
            <AuthenticatedLayout
                titleChildren={'Editar tipo de requerimento'}
                breadcrumbs={[{ label: 'Tipos de requerimento', url: route('types.index') }, { label: type.description, url: route('types.show', type.id) }, { label: 'Editar'}]}
            >
                <Panel>
                    <Form data={data} errors={errors} processing={processing} onHandleChange={onHandleChange} handleSubmit={handleSubmit} />
                </Panel>
            </AuthenticatedLayout>
        </>
    )
}

export default Edit;

