import React from "react";
import { Head, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Panel from "@/Components/Dashboard/Panel";
import Form from "./Components/Form";

function Create({ enrollments, requirement_types, weekdays, semesters }) {
    const { data, setData, post, processing, errors } = useForm({
        status: '',
        enrollment_id: '',
        requirement_type_id: '',
        semester_id: '',
        weekday: []
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('requirements.store'), {data});
    };

    return (
        <>
            <Head title="Novo requerimento" />
            <AuthenticatedLayout titleChildren={'Cadastro de novo requerimento'} breadcrumbs={[{ label: 'Requerimentos', url: route('requirements.index') }, { label: 'Novo', url: route('requirements.create') }]}>
                <Panel className={'flex-1'}>
                    <Form
                        data={data}
                        errors={errors}
                        processing={processing}
                        onHandleChange={onHandleChange}
                        handleSubmit={handleSubmit}
                        enrollments={enrollments}
                        requirement_types={requirement_types}
                        weekdays={weekdays}
                        semesters={semesters}
                    />
                </Panel>
            </AuthenticatedLayout>
        </>
    )
}

export default Create;

