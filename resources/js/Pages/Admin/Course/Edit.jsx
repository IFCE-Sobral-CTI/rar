import React from "react";
import { Head, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Panel from "@/Components/Dashboard/Panel";
import Form from "./Components/Form";

function Edit({ course, types }) {
    const { data, setData, put, processing, errors } = useForm({
        cod: course.cod,
        name: course.name,
        status: course.status? 1: 0,
        id: course.id,
        course_type_id: course.course_type_id
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
                    <Form
                        data={data}
                        errors={errors}
                        processing={processing}
                        onHandleChange={onHandleChange}
                        handleSubmit={handleSubmit}
                        types={types}
                    />
                </Panel>
            </AuthenticatedLayout>
        </>
    )
}

export default Edit;

