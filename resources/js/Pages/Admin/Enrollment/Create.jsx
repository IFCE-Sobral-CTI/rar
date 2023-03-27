import React from "react";
import { Head, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Panel from "@/Components/Dashboard/Panel";
import Form from "./Components/Form";

function Create({ student, courses }) {
    const { data, setData, post, processing, errors } = useForm({
        number: '',
        course_id: '',
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('students.enrollments.store', { student: student.id }), {data});
    };

    return (
        <>
            <Head title="Nova matricula" />
            <AuthenticatedLayout
                titleChildren={'Cadastro de nova matricula'}
                breadcrumbs={[
                    { label: 'Alunos(as)', url: route('students.index')},
                    { label: student.name, url: route('students.show', { student: student.id }) },
                    { label: 'Matricula', url: route('students.enrollments.index', { student: student.id }) },
                    { label: 'Nova', url: route('students.enrollments.create', { student: student.id }) },
                ]}
            >
                <Panel className={'flex-1'}>
                    <Form data={data} courses={courses} errors={errors} processing={processing} onHandleChange={onHandleChange} handleSubmit={handleSubmit} />
                </Panel>
            </AuthenticatedLayout>
        </>
    )
}

export default Create;

