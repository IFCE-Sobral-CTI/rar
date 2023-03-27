import React from "react";

export default function ShowField({ label, value }) {
    return (
        <div className="flex flex-col">
            <div className="text-sm font-light">{label}</div>
            <div className="">{value}</div>
        </div>
    )
}
