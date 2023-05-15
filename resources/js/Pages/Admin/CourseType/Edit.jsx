import React from "react";
import { Head, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Panel from "@/Components/Dashboard/Panel";
import Form from "./Components/Form";

function Edit({ course_type, levels }) {
    const { data, setData, put, processing, errors } = useForm({
        description: course_type.description,
        level: course_type.level,
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        put(route('course_types.update', course_type.id), {data});
    };

    return (
        <>
            <Head title="Editar curso" />
            <AuthenticatedLayout
                titleChildren={'Editar curso'}
                breadcrumbs={[
                    { label: 'Tipos de Cursos', url: route('course_types.index') },
                    { label: course_type.description, url: route('course_types.show', course_type.id) },
                    { label: 'Editar'}
                ]}
            >
                <Panel>
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

export default Edit;

