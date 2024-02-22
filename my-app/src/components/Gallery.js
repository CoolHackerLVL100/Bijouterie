import React, {Component} from "react"
import Navbar from "./Navbar"
import Modal from "./Modal"
import '../css/Gallery.css'

class Gallery extends Component {
    constructor(props){
        super(props)

        this.state = {
            icons: {
                close: '',
                backward: '',
                forward: ''
            },
            current: null,
            images: []
        }

        this.handleClose = this.handleClose.bind(this)
        this.handleBackward = this.handleBackward.bind(this)
        this.handleForward = this.handleForward.bind(this)
    }

    componentDidMount(){
        let schema = require('./Gallery_scheme.json')

        this.setState({
            images: schema?.images
        })

        const icon_names = ['close', 'backward', 'forward']
        const icons = {
            close: '',
            backward: '',
            forward: ''
        }
        icon_names.forEach((icon) => {
            fetch('http://localhost/Bijouterie/backend/api/image/icons/' + icon + '.svg')
            .then(res => res.text())
            .then(
                (result) => {
                    icons[icon] = result
                }, 
                (error) => {
                    console.log(error)
                }
            )
        })

        this.setState({
            icons: icons
        })
    }

    handleClose(){
        this.setState({
            current: null
        })
    }

    handleBackward(){
        this.setState({
            current: this.state.current == 0 ? this.state.images.length - 1 : this.state.current - 1
        }, () => {console.log(this.state.current)})
    }

    handleForward(){
        this.setState({
            current: this.state.current == this.state.images.length - 1 ? 0 : this.state.current + 1
        })
    }

    render(){
        return (
            <div>
                <Navbar/>
                
                <div className="container">
                    <div className="gallery">
                        {this.state.images?.length > 0 ? this.state.images.map((item, index) => {       
                            return (
                                <div 
                                    key={item.background_image} 
                                    className="image-wrapper" 
                                    style={{
                                        gridColumnStart: item['grid-column-start'], 
                                        gridColumnEnd: item['grid-column-end'],
                                        gridRowStart: item['grid-row-start'],
                                        gridRowEnd: item['grid-row-end'],
                                        aspectRatio: (item['grid-column-end']-item['grid-column-start']) + '/' + (item['grid-row-end']-item['grid-row-start'])
                                    }}
                                >
                                    <img 
                                        src={"http://localhost/Bijouterie/backend/api/image/gallery/" + item['background-image']} 
                                        onClick={() => {
                                            this.setState({
                                                current: index,                                                            
                                            })
                                        }}
                                    />                                       
                                </div>   
                            )
                        }) : 
                            <div>Отсутствуют изображения</div>
                        }
                    </div>
                </div>

                {
                    this.state.current != null ? (
                        <Modal 
                            onClose={this.handleClose} 
                            onBackward={this.handleBackward}
                            onForward={this.handleForward}
                            image={this.state.images[this.state.current]['background-image']}
                            icons={this.state.icons} 
                        />
                    ) : (null)
                }

            </div>
            
        )
    }
}

export default Gallery

