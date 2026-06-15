
import { Route, Routes as Routing } from "react-router-dom";
import Auth from "../pages/Auth";
import Home from "../pages/Home";

export default function Routes(){
    return (
        <Routing>
            <Route path="/" element={<Home />} />
            <Route path="/login" element={<Auth />} />
        </Routing>
    )
}