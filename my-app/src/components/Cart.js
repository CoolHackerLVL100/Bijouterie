
import React, {Component} from "react"
import Navbar from "./Navbar"
import '../css/Profile.css'
import getCookie from './Cookies'

class Cart extends Component {
    constructor(props){
        super(props)

        this.state = {
            is_loaded: true,
            delete: null,
            items: []
        }
    }

    getData(){
        fetch('http://localhost/Bijouterie/backend/api/user/' + getCookie('id') + '/cart/', {
            method: 'GET',
            credentials: 'include',
            headers: {
                Authorization: getCookie('jwt')
            }
        })
        .then(res => res.json())
        .then(
            (result) => {
                this.setState({
                    is_loaded: true,
                    items: result.data,
                    
                })                
            },
            (error) => {
                this.setState({
                    is_loaded: true,
                    error
                })
            }
        ) 
    }

    componentDidMount(){
        this.getData()
        
        fetch('http://localhost/Bijouterie/backend/api/image/icons/delete.svg')
        .then(res => res.text())
        .then(
            (result) => {
                this.setState({
                    delete: result
                })
            }, 
            (error) => {
                console.log(error)
            }
        )
    }

    refHandler(){
        //window.location = 'http://localhost/Bijouterie/backend/api/image/products'
        console.log('ref')
    }

    deleteHandler(event, id){
        fetch('http://localhost/Bijouterie/backend/api/user/' + getCookie('id') + '/' + 'cart/' + id + '/', {
            method: 'DELETE',
            credentials: 'include',
            headers: {
                Authorization: getCookie('jwt')
            }
        })
        .then(res => res.json())
        .then(
            (result) => {
                alert('Товар удалён')
                this.setState({
                    is_loaded: true,
                    //data: result.data,
                    
                })                
            },
            (error) => {
                this.setState({
                    is_loaded: true,
                    error
                })
            }
        )
        
        this.getData()
        //window.location = 'http://localhost/Bijouterie/backend/api/image/products/5'
        event.stopPropagation()
    }

    render(){
        return (
            <div className="cart PlayfairDisplay">
                <div className="cart_wrapper">
                    {this.state.items.length > 0 ? this.state.items.map(item => (
                        <div key={item.id} className="cart_item" id={item.id} onClick={this.refHandler} >
                            <img src={"http://localhost/Bijouterie/backend/api/image/products/" + item.photo}></img>
                            <p className="item-name">{item.name}</p>
                            <p className="item-price">{item.price}</p>
                            <div className="item-delete" dangerouslySetInnerHTML={{__html: this.state.delete}} data-key={item.id} onClick={(event) => this.deleteHandler(event, item.id)}></div>
                        </div>
                    )) : (
                        <div className="no-items PlayfairDisplay">
                            <p>Товары отсутствуют</p>
                        </div>
                    )} 
                    
                </div>
                
            </div>
        )
    }
}

export default Cart

