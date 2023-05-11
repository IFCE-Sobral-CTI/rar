import React from "react";
import { Head, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Panel from "@/Components/Dashboard/Panel";
import Form from "./Components/Form";

function Edit({ enrollment, courses, student }) {
    const { data, setData, put, processing, errors } = useForm({
        number: enrollment.number,
        course_id: enrollment.course.id,
        status: enrollment.status? 1: 0,
        student: student
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        put(route('students.enrollments.update', {enrollment: enrollment.id, student: student.id}), {data});
    };

    return (
        <>
            <Head title="Editar matrícula" />
            <AuthenticatedLayout
                titleChildren={'Editar matrícula'}
                breadcrumbs={[
                    { label: 'Alunos(as)', url: route('students.index')},
                    { label: enrollment.student.name, url: route('students.show', { student: enrollment.student.id }) },
                    { label: 'Matricula', url: route('students.enrollments.index', { student: enrollment.student.id }) },
                    { label: enrollment.number, url: route('students.enrollments.show', { student: enrollment.student.id, enrollment: enrollment.id }) },
                    { label: 'Editar', url: route('students.enrollments.create', { student: enrollment.student.id }) },
                ]}
            >
                <Panel>
                    <Form data={data} courses={courses} errors={errors} processing={processing} onHandleChange={onHandleChange} handleSubmit={handleSubmit} />
                </Panel>
            </AuthenticatedLayout>
        </>
    )
}

export default Edit;

