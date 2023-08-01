import React from "react";

export default function Header({ title, subtitle }) {
    return (
        <>
            <div className="p-2 mb-2 md:w-2/3 md:m-auto">
                <h1 className="text-2xl font-bold text-center md:mb-2 text-neutral-500">{title}</h1>
                {subtitle && <p className="text-center text-neutral-500">{subtitle}</p>}
            </div>
        </>
    )
}
