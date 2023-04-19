import React from "react";
import { Head, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Panel from "@/Components/Dashboard/Panel";
import Form from "./Components/Form";

function Edit({ weekday }) {
    const { data, setData, put, processing, errors } = useForm({
        description: weekday.description,
        status: weekday.status? 1: 0,
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        put(route('weekdays.update', weekday.id), {data});
    };

    return (
        <>
            <Head title="Editar dia da semana" />
            <AuthenticatedLayout titleChildren={'Editar dia da semana'} breadcrumbs={[{ label: 'Dias da semana', url: route('weekdays.index') }, { label: weekday.name, url: route('weekdays.show', weekday.id) }, { label: 'Editar'}]}>
                <Panel>
                    <Form data={data} errors={errors} processing={processing} onHandleChange={onHandleChange} handleSubmit={handleSubmit} />
                </Panel>
            </AuthenticatedLayout>
        </>
    )
}

export default Edit;

