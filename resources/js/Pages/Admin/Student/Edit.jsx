import React from "react";
import { Head, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Panel from "@/Components/Dashboard/Panel";
import Form from "./Components/Form";

function Edit({ student }) {
    const { data, setData, put, processing, errors } = useForm({
        cpf: student.cpf,
        rg: student.rg,
        name: student.name,
        birth: student.birth,
        personal_email: student.personal_email,
        institutional_email: student.institutional_email,
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        put(route('students.update', student.id), {data});
    };

    return (
        <>
            <Head title="Editar aluno(a)" />
            <AuthenticatedLayout titleChildren={'Editar aluno(a)'} breadcrumbs={[{ label: 'Alunos(as)', url: route('students.index') }, { label: student.name, url: route('students.show', student.id) }, { label: 'Editar'}]}>
                <Panel>
                    <Form data={data} errors={errors} processing={processing} onHandleChange={onHandleChange} handleSubmit={handleSubmit} />
                </Panel>
            </AuthenticatedLayout>
        </>
    )
}

export default Edit;

