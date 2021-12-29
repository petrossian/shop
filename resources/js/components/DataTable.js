import { useEffect, useState } from "react";

export default function DataTable() {
    const [products, setProduct] = useState([]);
    const [users, setUsers] = useState([]);
    useEffect(()=>{
        const handle = setTimeout(()=>{
            fetch("/admin/data")
                .then(stream=>stream.json())
                .then(json=>setProduct(json.products));
            fetch("/admin/data")
                .then(stream=>stream.json())
                .then(json=>setProduct(json.users));
        }, 10);
        return ()=>{
            clearTimeout(handle);
        }
        
    }, []);
    
    return (
        <div className="container">
               
                        <table className="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>TITLE</th>
                                    <th>BODY</th>
                                    <th>PRICE</th>
                                    <th>FILE</th>
                                </tr>
                            </thead>
                            <tbody>
                                {
                                    products.map((product, k)=>{
                                        return(
                                            <tr key={"product_"+k}>
                                                <td>{product.id}</td>
                                                <td>{product.title}</td>
                                                <td>{product.body}</td>
                                                <td>{product.price}</td>
                                                <td>{product.file}</td>
                                            </tr>
                                        )
                                    })
                                }
                            </tbody>
                        </table>
                        
                        <table className="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                {
                                    users.map((user, k)=>{
                                        return(
                                            <tr key={"user_"+k}>
                                                <td>{user.id}</td>
                                                <td>{user.name}</td>
                                            </tr>
                                        )
                                    })
                                }
                            </tbody>
                        </table>
        </div>
    );
}



