import React from "react";
import { Head, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Panel from "@/Components/Dashboard/Panel";
import Form from "./Components/Form";

function Edit({ semester }) {
    const { data, setData, put, processing, errors } = useForm({
        description: semester.description,
        start: semester.start.split('/').reverse().join('-'),
        end: semester.end.split('/').reverse().join('-'),
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        put(route('semesters.update', semester.id), {data});
    };

    return (
        <>
            <Head title="Editar semestre" />
            <AuthenticatedLayout titleChildren={'Editar semestre'} breadcrumbs={[{ label: 'Semestres', url: route('semesters.index') }, { label: semester.name, url: route('semesters.show', semester.id) }, { label: 'Editar'}]}>
                <Panel>
                    <Form data={data} errors={errors} processing={processing} onHandleChange={onHandleChange} handleSubmit={handleSubmit} />
                </Panel>
            </AuthenticatedLayout>
        </>
    )
}

export default Edit;

