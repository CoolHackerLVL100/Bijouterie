import React, {Component} from "react"
import '../css/Shop.css'
import Catalog from "./Catalog"
import Navbar from "./Navbar"
import Filter from "./Filter"
import Types from "./Types"

class Shop extends Component {
    constructor(props){
        super(props)
        this.state = {
            type: '',
            min_price: '5',
            max_price: '100',
            gender: 'f',
            size: [],
            stones: [],
            materials: []          
        }

        this.handleSubmit = this.handleSubmit.bind(this)
    }

    handleSubmit(filter){
        this.setState(filter, () => console.log(this.state))
    }

    render(){            
        return (
            <div>
                <Navbar />
                <div className="shop_section">
                    <div className="container">
                        <div className="main_content">
                            <Types type={this.state.type} onSubmit={this.handleSubmit}/>
                            <Filter 
                                min_price={this.state.min_price} 
                                max_price={this.state.max_price}
                                gender={this.state.gender}
                                size={this.state.size}
                                stones={this.state.stones}
                                materials={this.state.materials}
                                onSubmit={this.handleSubmit} 
                            />
                            <Catalog filter={this.state}/>  
                        </div>
                    </div>             
                </div> 
            </div>

        )
    }
}

export default Shop

