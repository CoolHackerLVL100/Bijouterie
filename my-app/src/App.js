import logo from './logo.svg'
import './App.css'
import Main from './components/Main.js'
import Shop from './components/Shop.js'
import NotFound from './components/NotFound.js'
import Gallery from './components/Gallery.js'
import Profile from './components/Profile.js'
import Admin from './components/Admin.js'
import {BrowserRouter as Router, Routes, Route} from 'react-router-dom'


function App() {
  return (
    <Router>
        <Routes>
            <Route path='/' element={<Main/>} />
            <Route path='/shop' element={<Shop/>}/>            
            <Route path='/gallery' element={<Gallery/>}/> 
            <Route path='/profile' element={<Profile/>}/> 
            <Route path='/admin' element={<Admin/>}/> 
            <Route path='*' element={<NotFound/>}/> 
        </Routes>
    </Router>
  );
}

export default App;
