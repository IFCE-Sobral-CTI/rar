import React from "react";
import { Head, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Panel from "@/Components/Dashboard/Panel";
import Form from "./Components/Form";

function Edit({ course }) {
    const { data, setData, put, processing, errors } = useForm({
        cod: course.cod,
        name: course.name,
        status: course.status,
        id: course.id,
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        put(route('courses.update', course.id), {data});
    };

    return (
        <>
            <Head title="Editar curso" />
            <AuthenticatedLayout titleChildren={'Editar curso'} breadcrumbs={[{ label: 'Curso', url: route('courses.index') }, { label: course.name, url: route('courses.show', course.id) }, { label: 'Editar'}]}>
                <Panel>
                    <Form data={data} errors={errors} processing={processing} onHandleChange={onHandleChange} handleSubmit={handleSubmit} />
                </Panel>
            </AuthenticatedLayout>
        </>
    )
}

export default Edit;

