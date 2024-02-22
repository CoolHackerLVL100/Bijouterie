import React, {Component} from "react"
import Navbar from "./Navbar"
import '../css/Product.css'
import Gallery from "./Gallery"

class Product extends Component {
    constructor(props){
        super(props)

        this.state = {
            is_loaded: null,
            product: null,
            reviews: null
        }

        this.getData = this.getData.bind(this)
    }

    getData(){
        fetch('http://localhost/Bijouterie/backend/api/product/' + window.location.pathname.split('/')[2] + '/', {
            method: 'GET'
        })
        .then(res => res.json())
        .then(
            (result) => {
                this.setState({
                    is_loaded: true,
                    product: result.data[0]
                })
            },
            (error) => {
                this.setState({
                    is_loaded: false
                })
            }
        )

        
    }

    componentDidMount(){
        this.getData()
    }

    render (){
        return (
            <div>
                <Navbar/>
                <div className="container">
                    {this.state.product ? (
                        <div className="product-info">
                            <img src={"http://localhost/Bijouterie/backend/api/image/products/" + this.state.product?.photo}></img>
                            <div className="product-attributes">
                                <div className="product-name">{this.state.product?.name}</div>
                                <div className="product-type">{this.state.product?.type}</div>
                                <div className="product-manufacturer">{this.state.product?.manufacturer}</div>
                                <div className="product-price">{this.state.product?.price}</div>
                                <div className="product-gender">{this.state.product?.gender}</div>
                                <div className="product-size">{this.state.product?.size}</div>
                            </div>
                        </div>                        
                    ) : (
                        <div> Ошибка</div>
                    )}

                    <div className="reviews">

                    </div>
                </div>

            </div>
        )                
    }
}

export default Product