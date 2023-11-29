import React, {Component} from "react"
import Card from "./Card"

class Catalog extends Component {
    constructor(props){
        super(props)
        this.state = {
            error: null,
            is_loaded: null,
            filter: this.props.filter,
            items: []
        }

        this.getData = this.getData.bind(this)
    }

    getData(params){
        fetch('http://localhost/Bijouterie/backend/api/product/?' + new URLSearchParams({
            type: params.type,
            gender: params.gender,
            min_price: params.min_price,
            max_price: params.max_price,
            size: params.size,
            stones: params.stones,
            materials: params.materials
        }), {
            method: 'GET'
        })
        .then(res => res.json())
        .then(
            (result) => {
                this.setState({
                    is_loaded: true,
                    items: result.data,
                    filter: params
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
        this.getData(this.props.filter)
    }

    componentDidUpdate(prevState, newState){    
        if (JSON.stringify(prevState.filter) != JSON.stringify(this.props.filter))
            this.getData(this.props.filter)       
    }

    render(){
        return (
            <div className="catalog">
                {this.state.items.length > 0 ? this.state.items.map(item => (
                    <Card 
                        key={item.id}
                        id={item.id}
                        type = {item.type} 
                        name={item.name}
                        manufacturer={item.manufacturer}
                        price={item.price}
                        photo={item.photo}
                        gender={item.gender}
                        size={item.size}
                        materials={item.materials}
                        stones={item.stones}
                    />
                )) : (
                    <div className="no-items PlayfairDisplay">
                        <p>Товары отсутствуют</p>            
                    </div>
                )}                    
            </div>
        )
    }
}

export default Catalog