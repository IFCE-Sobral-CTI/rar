import React from "react";
import { Head, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Panel from "@/Components/Dashboard/Panel";
import Form from "./Components/Form";

function Create({ levels }) {
    const { data, setData, post, processing, errors } = useForm({
        description: '',
        level: '',
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('course_types.store'), {data});
    };

    return (
        <>
            <Head title="Novo curso" />
            <AuthenticatedLayout
                titleChildren={'Cadastro de novo tipo de curso'}
                breadcrumbs={[
                    { label: 'Tipos de Cursos', url: route('course_types.index') },
                    { label: 'Novo', url: route('course_types.create') }
                ]}
            >
                <Panel className={'flex-1'}>
                    <Form
                        data={data}
                        errors={errors}
                        processing={processing}
                        onHandleChange={onHandleChange}
                        handleSubmit={handleSubmit}
                        levels={levels}
                    />
                </Panel>
            </AuthenticatedLayout>
        </>
    )
}

export default Create;

