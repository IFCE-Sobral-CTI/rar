import React from "react";
import { Head, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Panel from "@/Components/Dashboard/Panel";
import Form from "./Components/Form";

function Edit({ requirement, enrollments, requirement_types, weekdays, semesters, reprint_type }) {
    const { data, setData, put, processing, errors } = useForm({
        status: requirement.status,
        enrollment_id: requirement.enrollment_id,
        semester_id: requirement.semester_id,
        requirement_type_id: requirement.requirement_type_id,
        weekday: requirement.weekdays.map(item => item.id),
        justification: requirement.justification
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        put(route('requirements.update', requirement.id), {data});
    };

    return (
        <>
            <Head title="Editar Requerimento" />
            <AuthenticatedLayout titleChildren={'Editar Requerimento'} breadcrumbs={[{ label: 'Requerimentos', url: route('requirements.index') }, { label: requirement.name, url: route('requirements.show', requirement.id) }, { label: 'Editar'}]}>
                <Panel>
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
                        reprint_type={reprint_type}
                    />
                </Panel>
            </AuthenticatedLayout>
        </>
    )
}

export default Edit;

