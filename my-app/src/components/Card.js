import React, {Component} from "react"
import getCookie from './Cookies'

class Card extends Component {
    constructor(props){
        super(props)

        this.handleAdd = this.handleAdd.bind(this)
    }

    clearString(str){
        return str != 'NULL' ? str.substring(1, str.length-1).replaceAll('"', '').split(',').join(', ') : '-'
    }

    handleAdd(){
        fetch('http://localhost/Bijouterie/backend/api/user/' + getCookie('id') + '/' + 'cart/' + this.props.id + '/', {
            method: 'PUT',
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
             
    }
    
    render(){
        const {
            type: type, 
            name: name, 
            manufacturer: manufacturer, 
            price: price, 
            photo: photo, 
            gender: gender, 
            size: size, 
            materials: materials, 
            stones: stones
        } = this.props

        return (

            <div className="item PlayfairDisplay">
                <div className="item-image">
                    <img src={"http://localhost/Bijouterie/backend/api/image/products/" + photo}></img>
                </div>
                <div className="item-info">
                    <p className="item-name">{name}</p>
                    <p className="item-price">Тип: {type}</p>
                    <p className="item-manufacturer">Производитель: {manufacturer}</p>
                    <p className="item-gender">Пол: {gender}</p>
                    <p className="item-price">Цена: {price}</p>
                    <p className="item-materials">Материал: {this.clearString(materials)}</p>
                    <p className="item-stones">Вставки: {this.clearString(stones)}</p>
                </div>
                <div>
                    <button 
                        className="add-button" 
                        onClick={this.handleAdd} 
                        dangerouslySetInnerHTML={{__html: this.props.basket}}
                    >
                    </button>
                </div>
            </div>
        )
    }
}

export default Card