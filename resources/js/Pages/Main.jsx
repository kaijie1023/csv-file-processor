import React, { useState, useRef, useEffect, useCallback } from 'react';
import axios from 'axios';

const FileUploadPage = () => {
  const [inputFile, setInputFile] = useState(null);
  const [uploadedFiles, setUploadedFiles] = useState([]);
  const [polling, setPolling] = useState(false);
  const fileInputRef = useRef(null);
  const dropRef = useRef(null);

  const handleDrop = (e) => {
    e.preventDefault();
    setInputFile(e.dataTransfer.files[0]);
  };

  const handleFileChange = (e) => {
    setInputFile(e.target.files[0]);
  };

  const uploadFile = async (file) => {
    const formData = new FormData();
    formData.append('file', file);

    try {
      const res = await axios.post('http://localhost:8000/upload-csv', formData);

      if (res.status === 200) {
        fetchFileJob();
        setInputFile(null);
        setPolling(true);
      }
    } catch (err) {
      console.error('Upload error:', err);
    }
  };

  const handleUpload = async () => {
    await uploadFile(inputFile);
  };

  const formatTime = useCallback((date) => {
    const minsAgo = Math.floor((new Date() - date) / 60000);
    return `${date.toLocaleDateString()} ${date.toLocaleTimeString()} (${minsAgo} minutes ago)`;
  }, [uploadedFiles]);

  const fetchFileJob = async () => {
    try {
      const response = await axios.get('http://localhost:8000/file-logs');
      setUploadedFiles(response.data);
    } catch (error) {
      console.error('Polling error:', error);
    }
  };

  useEffect(() => {
    fetchFileJob();
  }, []);

  useEffect(() => {
    let interval;
    const POLL_INTERVAL = 1000;
    if (polling) {
      interval = setInterval(fetchFileJob, POLL_INTERVAL);
    } else {
      clearInterval(interval);
    }

    return () => clearInterval(interval);
  }, [polling]);

  useEffect(() => {
    if (uploadedFiles.every(file => file.status === 'completed' || file.status === 'failed')) {
      setPolling(false);
    }
  }, [uploadedFiles]);

  return (
    <div className="p-6 max-w-4xl mx-auto">
      <div
        ref={dropRef}
        onDragOver={(e) => e.preventDefault()}
        onDrop={handleDrop}
        className="flex flex-row items-center justify-between border-2 border-dashed border-gray-400 p-6 mb-4 text-center rounded"
      >
        <p onClick={() => fileInputRef.current.click()} className="cursor-pointer">Select file/Drag and drop</p>
        <input ref={fileInputRef} type="file" onChange={handleFileChange} className="mt-2 hidden" />
        <span className="text-gray-500">{inputFile?.name}</span>
        <button
          onClick={handleUpload}
          className={`px-4 py-2 rounded ${inputFile ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-500 cursor-not-allowed'}`}
          disabled={!inputFile}
        >
          Upload File
        </button>
      </div>

      <table className="w-full border border-gray-300 mt-6">
        <thead className="bg-gray-100">
          <tr>
            <th className="border px-4 py-2 text-left">Time</th>
            <th className="border px-4 py-2 text-left">File Name</th>
            <th className="border px-4 py-2 text-left">Status</th>
          </tr>
        </thead>
        <tbody>
          {uploadedFiles.map(file => (
            <tr key={file.id}>
              <td className="border px-4 py-2">{formatTime(new Date(file.created_at))}</td>
              <td className="border px-4 py-2">{file.file_name}</td>
              <td className="border px-4 py-2 capitalize">{file.status}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default FileUploadPage;
